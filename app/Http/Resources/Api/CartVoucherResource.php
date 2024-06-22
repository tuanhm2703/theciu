<?php

namespace App\Http\Resources\Api;

use App\Enums\OrderStatus;
use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class CartVoucherResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    static $selected_items = [];
    static $saved_voucher_ids = [];
    static $cart = null;
    static Customer $user;
    static int $total;
    public function toArray($request) {
        self::$user = requestUser();
        $voucherStatus = $this->updateVoucherDisableStatus();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'saveable' => (bool) $this->saveable,
            'voucher_type' => $this->voucher_type->code,
            'quantity_left' => $this->quantity,
            'min_order_value' => $this->min_order_value,
            'discount_type' => $this->discount_type,
            'max_discount_amount' => $this->max_discount_amount,
            'display' => $this->display,
            'begin' => $this->begin,
            'end' => $this->end,
            'num_of_days_left' => $this->end->diffInDays($this->begin),
            'saved' => false,
            'discount_value' => $this->value,
            'disabled' => $voucherStatus['disabled'],
            'disabled_reason' => $voucherStatus['disabled_reason']
        ];
    }

    private function updateVoucherDisableStatus() {
        $validate_voucher_data = app()->make('ValidateVoucherData');
        $disabled = false;
        $disabled_reason = '';
        if (count(self::$selected_items) == 0) {
            $disabled = true;
            $disabled_reason = "Vui lòng chọn sản phẩm để áp dụng voucher";
            // } else if ($this->voucher_type?->code == VoucherType::ORDER && $promotion_applied) {
            //     $disabled = true;
            //     $disabled_reason = "Bạn không thể áp dụng voucher đơn hàng khi đang sử dụng các khuyến mãi khác!";
        } else if ($this->total_can_use <= $validate_voucher_data->where('id', $this->id)->first()->orders_count) {
            $disabled = true;
            $disabled_reason = "Voucher đã hết lượt sử dụng";
        } else if (!$this->isValidTime()) {
            $disabled = true;
            $disabled_reason = "Thời gian áp dụng voucher không hợp lệ";
        } else if (self::$total < $this->min_order_value) {
            $disabled = true;
            $disabled_reason = "Đơn hàng chưa đạt giá trị tối thiểu (" . format_currency_with_label($this->min_order_value) . ")";
        } else if ($this->for_new_customer && !$this->canApplyNewCustomerVoucher()) {
            $disabled = true;
            $disabled_reason = "Voucher chỉ áp dụng cho khách hàng chưa mua đơn hàng tại web";
        } else if (in_array($this->id, self::$saved_voucher_ids)) {
            $disabled = false;
        } else if ($this->canApplyForCustomer(self::$user->id)) {
            $disabled = false;
        } else {
            $disabled = true;
            $disabled_reason = "Bạn đã sử dụng hết số lượt voucher";
        }
        return [
            'disabled' => $disabled,
            'disabled_reason' => $disabled_reason
        ];
    }

    private function canApplyNewCustomerVoucher() {
        return $this->user && !$this->user->orders()->whereIn('orders.order_status', OrderStatus::processingStatus())->exists();
    }
}
