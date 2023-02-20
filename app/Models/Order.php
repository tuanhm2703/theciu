<?php

namespace App\Models;

use App\Enums\ActionIcon;
use App\Enums\AddressType;
use App\Enums\CancelOrderRequestStatus;
use App\Enums\OrderStatus;
use App\Http\Services\Shipping\GHTKService;
use App\Traits\Common\Addressable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use App\Enums\OrderCanceler;
use App\Enums\PaymentStatus;
use App\Http\Services\Payment\PaymentService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Order extends Model {
    use HasFactory, Addressable;

    protected $fillable = [
        'customer_id',
        'total',
        'subtotal',
        'origin_subtotal',
        'shipping_fee',
        'order_number',
        'order_status',
        'cancel_reason',
        'payment_method_id',
        'canceled_by',
        'sub_status',
        'payment_status'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function pickup_address() {
        return $this->morphOne(Address::class, 'addressable')->where('type', AddressType::PICKUP)->withTrashed();
    }

    public function inventories() {
        return $this->belongsToMany(Inventory::class, 'order_items')->withTrashed()->withPivot([
            'total',
            'quantity',
            'origin_price',
            'promotion_price',
            'title',
            'name',
            'is_reorder'
        ]);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }

    public function order_histories() {
        return $this->hasMany(OrderHistory::class)->orderBy('created_at', 'desc');
    }

    public function shipping_order() {
        return $this->hasOne(ShippingOrder::class);
    }

    public function shipping_service() {
        return $this->hasOneThrough(ShippingService::class, ShippingOrder::class, 'order_id', 'id', null, 'shipping_service_id');
    }

    public function payment_method() {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function getOrderVoucherAttribute() {
        return $this->vouchers()->whereHas('voucher_type', function($q) {
            $q->where('voucher_types.code', VoucherType::ORDER);
        })->first();
    }

    public function vouchers() {
        return $this->belongsToMany(Voucher::class, 'order_vouchers')->withPivot([
            'amount',
            'type'
        ]);
    }

    public function pushShippingOrder() {
        $shipping_service = App::make(GHTKService::class);
        return $shipping_service->pushShippingOrder($this);
    }

    public function getCurrentStatusLabel() {
        switch ($this->order_status) {
            case OrderStatus::WAIT_TO_ACCEPT:
                return trans('order.order_status.wait_to_accept');
            case OrderStatus::WAITING_TO_PICK:
                return trans('order.order_status.waiting_to_pick');
            case OrderStatus::PICKING:
                return trans('order.order_status.picking');
            case OrderStatus::DELIVERING:
                return trans('order.order_status.delivering');
            case OrderStatus::DELIVERED:
                return trans('order.order_status.delivered');
            case OrderStatus::CANCELED:
                return trans('order.order_status.canceled');
            case OrderStatus::RETURN:
                return trans('order.order_status.return');
        }
    }
    public function createOrderHistory() {
        if ($this->order_status == OrderStatus::CANCELED && ($this->cancel_order_request != null && $this->cancel_order_request->status == CancelOrderRequestStatus::ACCEPTED)) {
            return;
        }
        $order_history = new OrderHistory();
        switch ($this->order_status) {
            case OrderStatus::WAIT_TO_ACCEPT:
                $action = Action::firstOrCreate(
                    array('name' => 'Đặt hàng'),
                    array('description' => 'Khách hàng tạo đơn hàng', 'icon' => ActionIcon::ORDER_OREDRED),
                );
                break;
            case OrderStatus::PICKING:
                $action = Action::firstOrCreate(
                    array('name' => 'Đang lấy hàng'),
                    array('description' => 'Đơn vị vận chuyển đang lấy hàng', 'icon' => ActionIcon::ORDER_PICKING_UP),
                );
                break;
            case OrderStatus::CANCELED:
                $action = Action::firstOrCreate(
                    array('name' => 'Đã hủy'),
                    array('description' => 'Đơn hàng bị hủy', 'icon' => ActionIcon::ORDER_CANCELED)
                );
                break;
            case OrderStatus::WAITING_TO_PICK:
                $action = Action::firstOrCreate(
                    array('name' => 'Đợi lấy hàng'),
                    array('description' => 'Cửa hàng xác nhận đơn hàng', 'icon' => ActionIcon::ORDER_CONFIRMED)
                );
                break;
            case OrderStatus::DELIVERING:
                $action = Action::firstOrCreate(
                    array('name' => 'Đang giao'),
                    array('description' => 'Đơn hàng đã được chuyển đến đơn vị vận chuyển', 'icon' => ActionIcon::ORDER_DELIVERING)
                );
                break;
            case OrderStatus::DELIVERED:
                $action = Action::firstOrCreate(
                    array('name' => 'Đã giao'),
                    array('description' => 'Đơn hàng đã được giao thành công', 'icon' => ActionIcon::ORDER_DELIVERED)
                );
                break;
            default:
                break;
        }
        if (auth('customer')->check()) {
            $order_history->executable_type = Customer::class;
            $order_history->executable_id = auth()->user()->id;
            if ($this->order_status == OrderStatus::CANCELED) {
                $this->canceled_by = OrderCanceler::CUSTOMER;
            }
        } else if (auth('web')->check()) {
            $order_history->executable_type = User::class;
            $order_history->executable_id = auth()->user()->id;
            if ($this->order_status == OrderStatus::CANCELED) {
                $this->canceled_by = OrderCanceler::SHOP;
            }
        } else if (Request::route() != null && Request::route()->getName() == 'webhook.shipping.webhook') {
            $order_history->executable_type = ShippingService::class;
            $order_history->executable_id = $this->shipping_service->id;
            if ($this->order_status == OrderStatus::CANCELED) {
                $this->canceler = OrderCanceler::SHIPPING_SERVICE;
            }
        } else {
            if ($this->order_status == OrderStatus::CANCELED) {
                $this->canceler = OrderCanceler::SYSTEM;
            }
        }
        $executor_label = $order_history->executorLabel();
        $order_history->description =  "$executor_label " . strtolower($action->name) . " đơn hàng $this->order_number";
        $order_history->action_id = $action->id;
        $order_history->order_status = $this->order_status;
        $order_history->order_id = $this->id;
        $order_history->save();
    }

    public function createPaymentOrderHistory() {
        $action = Action::firstOrCreate(
            array('name' => 'Thanh toán'),
            array('description' => 'Thanh toán đơn hàng', 'icon' => ActionIcon::ORDER_PAID)
        );
        $order_history = new OrderHistory();
        $order_history->executable_type = Customer::class;
        $order_history->executable_id = $this->customer_id;
        $executor_label = $order_history->executorLabel();
        $order_history->description =  "$executor_label " . strtolower($action->name) . " đơn hàng $this->order_number";
        $order_history->action_id = $action->id;
        $order_history->order_status = $this->order_status;
        $order_history->order_id = $this->id;
        $order_history->save();
    }
    public function isPaid() {
        return $this->payment && $this->payment->payment_status == PaymentStatus::PAID;
    }

    public function getCancelerLabel() {
        return OrderCanceler::getCancelerLabel($this->canceled_by);
    }

    public function refund() {
        return PaymentService::refund($this);
    }

    public function getRefundDescription() {
        $app_name = getAppName();
        return trans('order.description.refund_description', ['appName' => $app_name, 'orderNumber' => $this->order_number]);
    }

    public function getCheckoutDescription() {
        $app_name = getAppName();
        return trans('order.description.checkout_description', ['appName' => $app_name, 'orderNumber' => $this->order_number]);
    }

    public function restock() {
        $inventories = $this->inventories()->with('product')->get();
        foreach ($inventories as $inventory) {
            if ($inventory->pivot->is_reorder == 0) {
                $inventory->update([
                    'stock_quantity' => DB::raw("stock_quantity + " . $inventory->pivot->quantity)
                ]);
                $inventory->product->putKiotWarehouse(false);
            }
        }
    }

    public function removeStock() {
        $inventories = $this->inventories()->with('product')->get();
        foreach ($inventories as $inventory) {
            if ($inventory->product->is_reorder == 0 || ($inventory->product->is_reorder == 1 && $inventory->stock_quantity  - $inventory->pivot->quantity < 0)) {
                $inventory->update([
                    'stock_quantity' => DB::raw("stock_quantity - " . $inventory->pivot->quantity)
                ]);
                $inventory->product->putKiotWarehouse(true);
            }
        }
    }

    public function cancelShippingOrder() {
        if($this->shipping_order && $this->shipping_order->code) {
            App::make(GHTKService::class)->cancelOrder($this->shipping_order->code);
            return true;
        }
        return false;
    }

    public function getActualShippingFee() {
        return $this->shipping_order->shipping_order_histories->count() > 0 ? $this->shipping_order->shipping_order_histories->last()->fee : $this->shipping_fee;
    }

    /**
     * It calculates the final revenue of an order.
     *
     * @return The final revenue of the order.
     */
    public function getFinalRevenue() {
        $revenue = $this->subtotal - ($this->getActualShippingFee() - $this->shipping_order->total_fee);
        return $this->order_voucher ? $revenue - $this->order_voucher->pivot->amount : $revenue;
    }
}
