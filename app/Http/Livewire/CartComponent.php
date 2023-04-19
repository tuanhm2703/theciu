<?php

namespace App\Http\Livewire;

use App\Http\Services\Checkout\CheckoutModel;
use App\Http\Services\Checkout\CheckoutService;
use App\Http\Services\Shipping\GHTKService;
use App\Http\Services\Shipping\Models\DeliveryData;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\PaymentMethod;
use App\Models\Voucher;
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
        'cart:itemAdded' => 'updateOrderInfo',
        'cart:reloadVoucher' => 'reloadVoucher',
    ];
    public $address;
    public $estimateDeliveryFee = 0;
    public $shipping_service_types = [];
    public $service_id;
    private GHTKService $shipping_service;
    public $shipping_fee = 0;
    public $error = '';
    public $shipping_service_id;
    public $payment_methods;
    public $payment_method_id;
    public $item_selected = [];
    public $rank_discount_amount = 0;
    public $total;
    public $order_voucher_discount = 0;

    public $voucher_code;

    public $freeship_vouchers;

    public $order_vouchers;

    public $order_voucher_id;

    public $vouchers;
    public $order_voucher;
    public $save_voucher_ids = [];

    protected $rules = [
        'service_id' => 'required',
        'payment_method_id' => 'required',
        'address' => 'required',
        'item_selected' => 'array|min:1'
    ];

    protected $messages = [
        'service_id.required' =>  'Vui lòng chọn :attribute',
        'payment_method_id.required' => 'Vui lòng chọn :attribute',
        'address.required' => 'Vui lòng chọn :attribute',
        'item_selected.min' => 'Vui lòng chọn ít nhất 1 sản phẩm'
    ];


    protected $validationAttributes = [
        'service_id' => 'dịch vụ vận chuyển',
        'payment_method_id' => 'phương thức thanh toán',
        'address' => 'địa chỉ giao hàng'
    ];

    public function mount() {
        $this->cart =  Cart::with(['inventories' => function ($q) {
            return $q->with('image:path,imageable_id', 'product:id,slug,name')->whereHas('product');
        }])->firstOrCreate([
            'customer_id' => auth('customer')->user()->id
        ]);
        $this->address = auth('customer')->user()->shipping_address;
        $this->shipping_service = App::make(GHTKService::class);
        $this->shipping_service_id = $this->shipping_service->shipping_service->id;
        if ($this->address) {
            $this->shipping_service_types = $this->shipping_service->getShipServices($this->address);
            foreach ($this->shipping_service_types as $shipping_service_type) {
                $data = $this->calculateShippingInfo($shipping_service_type);
                $shipping_service_type->fee = $data['fee'];
                $shipping_service_type->delivery_date = $data['date'];
            }
            $this->service_id = $this->shipping_service_types[0]->service_id;
            $this->shipping_fee = $this->shipping_service_types[0]->fee;
        }
        $this->payment_methods = PaymentMethod::active()->with('image:imageable_id,path')->get();
        $this->save_voucher_ids = customer()->saved_vouchers()->available()->haveNotUsed()->pluck('id')->toArray();
        $this->vouchers = Voucher::select('vouchers.*')->available()->notSaveable()->union(customer()->saved_vouchers()->select('vouchers.*')->available()->haveNotUsed())->get();
        $this->updateVoucherDisableStatus();
    }

    public function reloadVoucher() {
        $this->save_voucher_ids = customer()->saved_vouchers()->available()->haveNotUsed()->pluck('id')->toArray();
        $this->vouchers = Voucher::select('vouchers.*')->available()->notSaveable()->union(customer()->saved_vouchers()->select('vouchers.*')->available()->haveNotUsed())->get();
        $this->updateVoucherDisableStatus();
    }

    private function updateVoucherDisableStatus() {
        foreach($this->vouchers as $voucher) {
            if (count($this->item_selected) == 0) {
                $voucher->disabled = true;
            } else if ($this->total < $voucher->min_order_value) {
                $voucher->disabled = true;
            } else if(in_array($voucher->id, $this->save_voucher_ids)) {
                $voucher->disabled = false;
            } else if($voucher->canApplyForCustomer(customer()->id)) {
                $voucher->disabled = false;
            } else {
                $voucher->disabled = true;
            }
            if($voucher->disabled && $this->order_voucher_id == $voucher->id) {
                $this->order_voucher_id = null;
                $this->order_voucher = null;
            }
        }
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
    public function checkOrder() {
        $this->validate();
        $this->emit('open-confirm-order');
    }
    public function checkout() {
        $this->validate();
        $this->error = '';
        $checkoutModel = new CheckoutModel([
            'address' => $this->address,
            'cart' => $this->cart,
            'shipping_fee' => $this->shipping_fee,
            'payment_method_id' => $this->payment_method_id,
            'shipping_service_id' => $this->shipping_service_id,
            'service_id' => $this->service_id,
            'item_selected' => $this->item_selected,
            'order_voucher_id' => $this->order_voucher_id
        ]);
        try {
            $redirectUrl = CheckoutService::checkout($checkoutModel);
            return redirect()->to($redirectUrl);
        } catch (\Throwable $th) {
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
        $this->updateOrderInfo($address);
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
        $package_info = $this->cart->getPackageInfoBySelectedItems($this->item_selected);
        $deliveryData = new DeliveryData(
            $this->address,
            $shipping_service_type->service_id,
            $shipping_service_type->service_type_id,
            $this->cart->getTotalWithSelectedItems($this->item_selected),
            $package_info->weight,
            $package_info->length,
            $package_info->width,
            $package_info->height
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
        $this->emitTo('header-cart-component', 'cart:refresh');
    }

    public function updateOrderInfo(Address $address = null) {
        $this->shipping_service_types = $this->address ? App::make(GHTKService::class)->getShipServices($this->address) : [];
        foreach ($this->shipping_service_types as $shipping_service_type) {
            $data = $this->calculateShippingInfo($shipping_service_type);
            $shipping_service_type->fee = $data['fee'];
            $shipping_service_type->delivery_date = $data['date'];
        }
        if(count($this->shipping_service_types) > 0) {
            $this->service_id = $this->shipping_service_types[0]->service_id;
            $this->shipping_fee = $this->shipping_service_types[0]->fee;
        }
        $this->rank_discount_amount = customer()->calculateRankDiscountAmount($this->cart->getTotalWithSelectedItems($this->item_selected));
        $this->total = $this->cart->getTotalWithSelectedItems($this->item_selected) - $this->rank_discount_amount;
        $this->updateVoucherDisableStatus();
        $this->order_voucher_discount = $this->order_voucher ? $this->order_voucher->getDiscountAmount($this->total) : 0;
    }

    public function updated($name, $value) {
        if($name == 'order_voucher_id') {
            $this->order_voucher = Voucher::find($value);
            $this->updateOrderInfo($this->address);
        }
    }

    public function applyVoucher() {
        $voucher = Voucher::where('code', $this->voucher_code)->where(function($q) {
            $q->notSaveable()->orWhere(function($q) {
                $q->whereHas('customers', function($q) {
                    $q->where('customers.id', customer()->id);
                });
            });
        })->first();
        if(!$voucher) {
            $this->dispatchBrowserEvent('openToast', [
                'message' => 'Voucher không hợp lệ',
                'type' => 'error'
            ]);
        } else {
            $this->updateVoucherDisableStatus();
            $voucher = $this->vouchers->where('id', $voucher->id)->first();
            if($voucher->disabled) {
                $this->dispatchBrowserEvent('openToast', [
                    'message' => 'Đơn hàng chưa đủ điều kiện áp dụng voucher',
                    'type' => 'error'
                ]);
            } else {
                $this->order_voucher_id = $voucher->id;
                $this->updateOrderInfo();
                $this->dispatchBrowserEvent('openToast', [
                    'message' => 'Áp dụng voucher thành công',
                    'type' => 'success'
                ]);
            }
        }
    }
}
