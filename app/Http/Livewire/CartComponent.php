<?php

namespace App\Http\Livewire;

use App\Enums\OrderStatus;
use App\Enums\PromotionType;
use App\Http\Services\Checkout\CheckoutModel;
use App\Http\Services\Checkout\CheckoutService;
use App\Http\Services\Shipping\GHTKService;
use App\Http\Services\Shipping\Models\DeliveryData;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Promotion;
use App\Models\Voucher;
use App\Models\VoucherType;
use Illuminate\Database\Eloquent\Collection;
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
    protected $queryString = ['item_selected', 'shipping_service_id', 'payment_method_id'];
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
    public $combo_discount = 0;
    public $total;

    public $voucher_code;

    public $order_voucher;
    public $order_voucher_id;
    public $order_voucher_discount = 0;

    public $freeship_voucher;
    public $freeship_voucher_id;
    public $freeship_voucher_discount = 0;

    public $vouchers;
    public $note;
    public $save_voucher_ids = [];
    public $promotion_applied = false;
    public Customer $customer;
    public $accom_gift_promotion = null;
    public $accom_inventory_ids = [];
    public $accom_inventories;
    protected $rules = [
        'service_id' => 'required',
        'payment_method_id' => 'required',
        'address' => 'required',
        'item_selected' => 'array|min:1',
        'note' => 'string|nullable|max:120'
    ];

    protected $messages = [
        'service_id.required' =>  'Vui lòng chọn :attribute',
        'payment_method_id.required' => 'Vui lòng chọn :attribute',
        'address.required' => 'Vui lòng chọn :attribute',
        'item_selected.min' => 'Vui lòng chọn ít nhất 1 sản phẩm',
        'note.regex' => 'Chú thích không được có ký tự đặc biệt'
    ];


    protected $validationAttributes = [
        'service_id' => 'dịch vụ vận chuyển',
        'payment_method_id' => 'phương thức thanh toán',
        'address' => 'địa chỉ giao hàng'
    ];

    public function boot(GHTKService $shipping_service) {
        $this->shipping_service = $shipping_service;
    }
    private function getCart(): void {
        $this->getAddress();
        if (!auth('customer')->check()) {
            $this->cart = session()->has('cart') ? unserialize(session()->get('cart')) : new Cart();
        } else {
            $this->cart = Cart::with(['inventories' => function ($q) {
                return $q->with('image:path,imageable_id', 'product:id,slug,name');
            }])->firstOrCreate([
                'customer_id' => $this->customer->id
            ]);
        }
    }
    public function mount() {
        $this->accom_inventories = new Collection();
        $this->customer = customer() ?? new Customer();
        $this->getCart();
        $this->shipping_service_id = $this->shipping_service->shipping_service->id;
        if ($this->address) {
            $this->shipping_service_types = $this->shipping_service->getShipServices($this->address);
            foreach ($this->shipping_service_types as $shipping_service_type) {
                $data = $this->calculateShippingInfo($shipping_service_type);
                $shipping_service_type->fee = $data['fee'];
                $shipping_service_type->delivery_date = now()->diffInDays($data['default_format_date']) <= 1 ? now()->addDays(2 - now()->diffInDays($data['default_format_date'])) : $data['default_format_date'];
                $shipping_service_type->delivery_date = $shipping_service_type->delivery_date->clone()->format('d/m') . " - " . $shipping_service_type->delivery_date->clone()->addDays(2)->format('d/m');
            }
            $this->service_id = $this->shipping_service_types[0]->service_id;
            $this->shipping_fee = $this->shipping_service_types[0]->fee;
        }
        $this->payment_methods = PaymentMethod::active()->with('image:imageable_id,path')->get();
        $this->save_voucher_ids = $this->customer->saved_vouchers()->active()->public()->notExpired()->haveNotUsed()->pluck('id')->toArray();
        $this->vouchers = Voucher::voucherForCart($this->customer)->get();
        if (count($this->item_selected) > 0) {
            $this->updateOrderInfo();
        } else {
            $this->updateVoucherDisableStatus();
        }
    }

    public function reloadVoucher() {
        $this->save_voucher_ids = $this->customer->saved_vouchers()->public()->notExpired()->haveNotUsed()->pluck('id')->toArray();
        $this->vouchers = Voucher::voucherForCart($this->customer)->get();
        $this->updateVoucherDisableStatus();
    }

    /**
     * The function "updateVoucherDisableStatus" updates the disable status and disable reason of
     * vouchers based on various conditions.
     */
    private function updateVoucherDisableStatus() {
        $validate_voucher_data = Voucher::whereIn('id', $this->vouchers->pluck('id')->toArray())->withCount(['orders' => function ($q) {
            $q->where('orders.order_status', '!=', OrderStatus::CANCELED);
        }])->get();
        foreach ($this->vouchers as $voucher) {
            if (count($this->item_selected) == 0) {
                $voucher->disabled = true;
                $voucher->disable_reason = "Vui lòng chọn sản phẩm để áp dụng voucher";
            } else if ($voucher->voucher_type?->code == VoucherType::ORDER && $this->promotion_applied) {
                $voucher->disabled = true;
                $voucher->disable_reason = "Bạn không thể áp dụng voucher đơn hàng khi đang sử dụng các khuyến mãi khác!";
            } else if ($voucher->total_can_use <= $validate_voucher_data->where('id', $voucher->id)->first()->orders_count) {
                $voucher->disabled = true;
                $voucher->disable_reason = "Voucher đã hết lượt sử dụng";
            } else if (!$voucher->isValidTime()) {
                $voucher->disabled = true;
                $voucher->disable_reason = "Thời gian áp dụng voucher không hợp lệ";
            } else if ($this->total < $voucher->min_order_value) {
                $voucher->disabled = true;
                $voucher->disable_reason = "Đơn hàng chưa đạt giá trị tối thiểu (" . format_currency_with_label($voucher->min_order_value) . ")";
            } else if (in_array($voucher->id, $this->save_voucher_ids)) {
                $voucher->disabled = false;
            } else if ($voucher->canApplyForCustomer($this->customer->id)) {
                $voucher->disabled = false;
            } else {
                $voucher->disabled = true;
                $voucher->disable_reason = "Bạn đã sử dụng hết số lượt voucher";
            }
            if ($voucher->disabled && $this->order_voucher_id == $voucher->id) {
                $this->order_voucher_id = null;
                $this->order_voucher = null;
            }
            if ($voucher->disabled && $this->freeship_voucher_id == $voucher->id) {
                $this->freeship_voucher_id = null;
                $this->freeship_voucher = null;
            }
        }
    }

    public function render() {
        return view('livewire.cart-component');
    }

    public function deleteInventory(Inventory $inventory) {
        if(customer()) {
            $this->cart->inventories()->detach($inventory->id);
        } else {
            $this->getCart();
            $this->cart->inventories = $this->cart->inventories->filter(function($i) use ($inventory) {
                return $i->id != $inventory->id;
            });
            session()->put('cart', serialize($this->cart));
        }
        $this->updateOrderInfo();
    }

    public function refresh() {
        $this->getCart();
    }
    public function checkOrder() {
        $this->accom_inventories = Inventory::whereIn('id', $this->accom_inventory_ids)->get();
        $this->getCart();
        $this->validate();
        $this->emit('open-confirm-order');
    }
    public function checkout() {
        $this->getCart();
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
            'order_voucher_id' => $this->order_voucher_id,
            'freeship_voucher_id' => $this->freeship_voucher_id,
            'note' => $this->note,
            'customer' => $this->customer,
            'accom_inventories' => $this->accom_inventories
        ]);
        $result = CheckoutService::checkout($checkoutModel);
        if($result['error']) {
            $this->error = $result['message'];
            $this->dispatchBrowserEvent('closeModal');
        } else {
            return redirect()->to($result['redirectUrl']);
        }
    }

    public function changeAddress($id) {
        if (customer()) {
            $this->address = Address::find($id);
        } else {
            session()->put('cart_address_id', $id);
            $this->getAddressFromSession($id);
        }
        $this->updateOrderInfo();
    }
    private function getAddress() {
        if (!customer()) {
            if (session()->has('cart_address_id')) $this->getAddressFromSession(session()->has('cart_address_id'));
        }
    }
    private function getAddressFromSession($id = null) {
        $addresses = getSessionAddresses();
        if($id && $addresses->where('id', $id)->first()) {
            $this->address = $addresses->where('id', $id)->first();
            if ($this->address) $this->address->load('province', 'district', 'ward');
        } else {
            $this->address = $addresses->where('featured', 1)->first();
        }
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
        $fee = $this->shipping_service->calculateDeliveryFee($deliveryData)->total;
        $date = $this->shipping_service->calculateDeliveryTime($deliveryData);
        return [
            'fee' => $fee,
            'date' => $date->clone()->format('d-m-Y'),
            'default_format_date' => $date
        ];
    }




    public function itemAdded(Inventory $inventory, $quantity) {
        $this->getCart();
        if (!customer()) {
            $this->addInventorySession($inventory, $quantity);
        } else {
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
                'customer_id' => $this->customer->id
            ]);
        }
        $this->updateOrderInfo();
        $this->emitTo('header-cart-component', 'cart:refresh');
    }
    private function addInventorySession(Inventory $inventory, $quantity) {
        if (session()->has('cart')) {
            $this->cart = unserialize(session()->get('cart'));
        } else {
            $this->cart = new Cart();
        }
        $i = $this->cart->inventories->where('id', $inventory->id)->first();
        if ($i) {
            $i->order_item->quantity = $quantity;
            $this->cart->inventories = $this->cart->inventories->filter(function (Inventory $inven) use ($i) {
                return $inven->id != $i->id;
            });
            $this->cart->inventories->put($inventory->id, $i);
        } else {
            $i = $inventory;
            $i->order_item = new OrderItem([
                'quantity' => $quantity,
            ]);
            $this->cart->inventories->push($i);
        }
        session()->put('cart', serialize($this->cart));
    }

    public function updateOrderInfo() {
        $this->getCart();
        $this->shipping_service_types = $this->address ? App::make(GHTKService::class)->getShipServices($this->address) : [];
        foreach ($this->shipping_service_types as $shipping_service_type) {
            $data = $this->calculateShippingInfo($shipping_service_type);
            $shipping_service_type->fee = $data['fee'];
            $shipping_service_type->delivery_date = $data['date'];
            $shipping_service_type->delivery_date = now()->diffInDays($data['default_format_date']) <= 1 ? now()->addDays(2 - now()->diffInDays($data['default_format_date'])) : $data['default_format_date'];
            $shipping_service_type->delivery_date = $shipping_service_type->delivery_date->clone()->format('d/m') . " - " . $shipping_service_type->delivery_date->clone()->addDays(2)->format('d/m');
        }
        if (count($this->shipping_service_types) > 0) {
            $this->service_id = $this->shipping_service_types[0]->service_id;
            $this->shipping_fee = $this->shipping_service_types[0]->fee;
        }
        $base_total = $this->cart->getTotalWithBasePriceItems($this->item_selected);
        $sub_total = $this->cart->getTotalWithSelectedItems($this->item_selected);
        $this->promotion_applied = $base_total > $sub_total;
        $this->rank_discount_amount = $this->customer->calculateRankDiscountAmount($sub_total);
        $this->combo_discount = $this->cart->calculateComboDiscount($this->item_selected)->sum('discount_amount');
        $this->promotion_applied = $this->promotion_applied == false && $this->combo_discount > 0;
        $this->freeship_voucher_discount = $this->freeship_voucher ? $this->freeship_voucher->getDiscountAmount($this->shipping_fee) : 0;
        $this->updateVoucherDisableStatus();
        $this->order_voucher_discount = $this->order_voucher ? $this->order_voucher->getDiscountAmount($this->total) : 0;
        $this->total -= $this->order_voucher_discount;
        $this->total = $this->cart->getTotalWithSelectedItems($this->item_selected) - $this->rank_discount_amount - $this->combo_discount + ($this->shipping_fee - $this->freeship_voucher_discount);
        $accom_promotion = Promotion::where('type', PromotionType::ACCOM_GIFT)->with(['products' => function($q) {
            return $q->select('name', 'id', 'slug')->with('inventories', function($q) {
                $q->where('promotion_status', 1)->where('stock_quantity', '>=', 'quantity_each_order');
            })->availableCannotView();
        }])->available()->where('min_order_value', '<=', $this->total)->orderBy('min_order_value', 'desc')->first();
        if($accom_promotion == null) {
            $this->accom_gift_promotion = $accom_promotion;
            $this->accom_inventories = new Collection();
            $this->accom_inventory_ids = [];
        } else if($accom_promotion->id != $this->accom_gift_promotion?->id) {
            $this->accom_gift_promotion = $accom_promotion;
            foreach($this->accom_gift_promotion->products as $product) {
                $this->accom_inventory_ids[] = $product->inventory->id;
            }
        }
    }

    public function updated($name, $value) {
        $this->getCart();
        if ($name == 'order_voucher_id') {
            $this->order_voucher = Voucher::active()->find($value);
            $this->updateOrderInfo();
        }
        if ($name == 'freeship_voucher_id') {
            $this->freeship_voucher = Voucher::active()->find($value);
            $this->updateOrderInfo();
        }
        if($name == 'accom_inventory_id') {
            $this->accom_gift_promotion = Promotion::where('type', PromotionType::ACCOM_GIFT)->with(['products' => function($q) {
                return $q->select('name', 'id', 'slug')->with('inventories', function($q) {
                    $q->where('promotion_status', 1)->where('stock_quantity', '>=', 'quantity_each_order');
                })->available();
            }])->available()->where('min_order_value', '<=', $this->total)->orderBy('min_order_value', 'desc')->first();
        }
    }

    public function applyVoucher() {
        $voucher = Voucher::available()->where('code', $this->voucher_code)->where(function ($q) {
            $q->notSaveable();
        })->first();
        if (!$voucher) {
            $this->dispatchBrowserEvent('openToast', [
                'message' => 'Voucher không hợp lệ',
                'type' => 'error'
            ]);
        } else {
            if ($voucher->isPrivate() && !$this->vouchers->where('id', $voucher->id)->first()) {
                $this->vouchers->push($voucher);
            }
            $this->updateVoucherDisableStatus();
            $voucher = $this->vouchers->where('id', $voucher->id)->first();
            if ($voucher->disabled) {
                $this->dispatchBrowserEvent('openToast', [
                    'message' => $voucher->disable_reason,
                    'type' => 'error'
                ]);
            } else {
                if ($voucher->voucher_type->code == VoucherType::ORDER) {
                    $this->order_voucher_id = $voucher->id;
                    $this->order_voucher = $voucher;
                } else {
                    $this->freeship_voucher_id = $voucher->id;
                    $this->freeship_voucher = $voucher;
                }
                $this->updateOrderInfo();
                $this->dispatchBrowserEvent('openToast', [
                    'message' => 'Áp dụng voucher thành công',
                    'type' => 'success'
                ]);
            }
        }
    }
    public function changeAccomInventory(Inventory $inventory) {
        $this->accom_inventory = $inventory;
    }

}
