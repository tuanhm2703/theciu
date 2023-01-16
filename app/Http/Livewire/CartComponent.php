<?php

namespace App\Http\Livewire;

use App\Enums\OrderStatus;
use App\Exceptions\InventoryOutOfStockException;
use App\Http\Services\Momo\MomoService;
use App\Http\Services\Payment\PaymentService;
use App\Http\Services\Shipping\GHTKService;
use App\Http\Services\Shipping\Models\DeliveryData;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Config;
use App\Models\Inventory;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CartComponent extends Component {
    public $cart;
    protected $listeners = [
        'cart:itemDeleted' => 'deleteInventory',
        'cart:refresh' => '$refresh',
        'cart:changeAddress' => 'changeAddress',
        'cart:itemAdded' => 'updateOrderInfo'
    ];
    public $address;
    public $estimateDeliveryFee = 0;
    public $shipping_service_types;
    public $service_id;
    private GHTKService $shipping_service;
    public $shipping_fee = 0;
    public $error = '';
    public $shipping_service_id;
    public $payment_methods;
    public $payment_method_id;

    public function mount() {
        $this->cart =  Cart::with(['inventories' => function ($q) {
            return $q->with('image:path,imageable_id', 'product:id,slug,name');
        }])->firstOrCreate([
            'customer_id' => auth('customer')->user()->id
        ]);
        $this->address = auth('customer')->user()->shipping_address;
        $this->shipping_service = App::make(GHTKService::class);
        $this->shipping_service_id = $this->shipping_service->shipping_service->id;
        $this->shipping_service_types = $this->shipping_service->getShipServices($this->address);
        foreach ($this->shipping_service_types as $index => $shipping_service_type) {
            $data = $this->calculateShippingInfo($shipping_service_type);
            $shipping_service_type->fee = $data['fee'];
            $shipping_service_type->delivery_date = $data['date'];
        }
        $this->service_id = $this->shipping_service_types[0]->service_id;
        $this->shipping_fee = $this->shipping_service_types[0]->fee;
        $this->payment_methods = PaymentMethod::active()->with('image:imageable_id,path')->get();
    }

    public function render() {
        return view('livewire.cart-component');
    }

    public function deleteInventory(Inventory $inventory) {
        $this->cart->inventories()->detach($inventory->id);
    }

    public function refresh() {
        $this->cart = Cart::with(['inventories' => function ($q) {
            return $q->with('image:path,imageable_id', 'product:id,slug,name');
        }])->firstOrCreate([
            'customer_id' => auth('customer')->user()->id
        ]);
    }

    public function checkout() {
        $this->error = '';
        DB::beginTransaction();
        $customer = auth('customer')->user();
        try {
            $order = $customer->orders()->create([
                'total' => 0,
                'subtotal' => 0,
                'origin_subtotal' => 0,
                'shipping_fee' => 0,
                'order_status' => OrderStatus::WAIT_TO_ACCEPT,
                'payment_method_id' => $this->payment_method_id
            ]);
            foreach ($this->cart->inventories as $inventory) {
                $order->inventories()->attach([
                    $inventory->id => [
                        'product_id' => $inventory->product_id,
                        'quantity' => $inventory->pivot->quantity,
                        'origin_price' => $inventory->price,
                        'promotion_price' => $inventory->sale_price,
                        'total' => $inventory->sale_price * $inventory->pivot->quantity,
                        'title' => $inventory->title,
                        'name' => $inventory->name

                    ]
                ]);
                if ($inventory->stock_quantity  - $inventory->pivot->quantity < 0)
                    throw new InventoryOutOfStockException("Sản phẩm $inventory->name không đủ số lượng", 409);
                $inventory->update([
                    'stock_quantity' => DB::raw("stock_quantity - " . $inventory->pivot->quantity)
                ]);
            }
            $order->update([
                'total' => $order->inventories()->sum('order_items.total') + $order->shipping_fee,
                'subtotal' => $order->inventories()->sum('order_items.total'),
                'origin_subtotal' => $order->inventories()->sum(DB::raw('order_items.origin_price * order_items.quantity')),
            ]);
            $order->shipping_order()->create([
                'shipping_service_id' => $this->shipping_service_id,
                'to_address' => $this->address->full_address,
                'shipping_service_code' => $this->service_id,
                "order_value" => $order->subtotal,
                'pickup_address_id' => Config::first()->pickup_address->id,
                "cod_amount" => $order->subtotal,
                "total_fee" => $order->subtotal,
                'ship_at_office_hour' => 0,
            ]);
            $this->cart->inventories()->sync([]);
            $url = PaymentService::checkout($order);
            DB::commit();
            $this->refresh();
            return redirect()->to($url);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            if ($th->getCode() !== 500) {
                $this->error = $th->getMessage();
            } else {
                $this->error = 'Đã có lỗi xảy ra, vui lòng liên hệ bộ phận chăm sóc khách hàng để nhận hỗ trợ.';
            }
        }
    }

    public function changeAddress(Address $address) {
        $this->address = $address;
        $this->updateOrderInfo();
    }

    public function updatedServiceId($value) {
        foreach ($this->shipping_service_types as $shipping_service_type) {
            if (((object) $shipping_service_type)->service_id == $value) {
                $this->shipping_fee = ((object) $shipping_service_type)->fee;
                $this->service_id = $value;
            };
        }
    }

    private function calculateShippingInfo($shipping_service_type) {
        $shipping_service_type = (object) $shipping_service_type;
        $deliveryData = new DeliveryData(
            auth()->user()->shipping_address,
            $shipping_service_type->service_id,
            $shipping_service_type->service_type_id,
            $this->cart->total(),
            $this->cart->package_info->weight,
            $this->cart->package_info->length,
            $this->cart->package_info->width,
            $this->cart->package_info->height
        );
        $fee = App::make(GHTKService::class)->calculateDeliveryFee($deliveryData)->total;
        $date = App::make(GHTKService::class)->calculateDeliveryTime($deliveryData)->format('d/m/Y');
        return [
            'fee' => $fee,
            'date' => $date
        ];
    }

    public function itemAdded(Inventory $inventory, $quantity) {
        if ($this->cart->inventories()->where('inventories.id', $inventory->id)->exists()) {
            $this->cart->inventories()->sync([$inventory->id => [
                'quantity' => $quantity ? $quantity : DB::raw("cart_items.quantity + 1")
            ]], false);
        } else {
            $this->cart->inventories()->sync([$inventory->id => [
                'quantity' => $quantity ? $quantity : 1, 'customer_id' => $this->cart->id
            ]], false);
        }
        $this->cart =  Cart::with(['inventories' => function ($q) {
            return $q->with('image:path,imageable_id', 'product:id,slug,name');
        }])->firstOrCreate([
            'customer_id' => auth('customer')->user()->id
        ]);
        $this->updateOrderInfo();
        $this->emit('cart:refresh');
    }

    public function updateOrderInfo() {
        foreach ($this->shipping_service_types as $index => $shipping_service_type) {
            $data = $this->calculateShippingInfo($shipping_service_type);
            $this->shipping_service_types[$index]['fee'] = $data['fee'];
            $this->shipping_service_types[$index]['delivery_date'] = $data['date'];
            if ($this->shipping_service_types[$index]['service_id'] == $this->service_id) {
                $this->shipping_fee = $this->shipping_service_types[$index]['fee'];
            }
        }
    }
}
