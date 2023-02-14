<?php

namespace App\Http\Services\Checkout;

use App\Models\Address;
use App\Models\Voucher;

class CheckoutModel {
    private Address $address;
    private $shipping_fee;
    private $payment_method_id;
    private $cart;
    private $shipping_service_id;
    private $item_selected;
    private $order_voucher_id;
    private $order_voucher;

    public function __construct($properties) {
        $this->mapProperties($properties);
    }

    protected function mapProperties(array $properties = []): void {
        foreach ($properties as $key => $val) {
            $ucFirst = ucfirst(\Str::camel($key));
            $setter = 'set' . $ucFirst;
            if (property_exists($this, $key) && method_exists($this, $setter)) {
                $this->$setter($val);
            }
        }
    }

    /**
     * Get the value of address
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set the value of address
     *
     * @return  self
     */
    public function setAddress($address) {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of shipping_fee
     */
    public function getShippingFee() {
        return $this->shipping_fee;
    }

    /**
     * Set the value of shipping_fee
     *
     * @return  self
     */
    public function setShippingFee($shipping_fee) {
        $this->shipping_fee = $shipping_fee;

        return $this;
    }

    /**
     * Get the value of payment_method_id
     */
    public function getPaymentMethodId() {
        return $this->payment_method_id;
    }

    /**
     * Set the value of payment_method_id
     *
     * @return  self
     */
    public function setPaymentMethodId($payment_method_id) {
        $this->payment_method_id = $payment_method_id;

        return $this;
    }

    /**
     * Get the value of shipping_service_id
     */
    public function getShippingServiceId() {
        return $this->shipping_service_id;
    }

    /**
     * Set the value of shipping_service_id
     *
     * @return  self
     */
    public function setShippingServiceId($shipping_service_id) {
        $this->shipping_service_id = $shipping_service_id;

        return $this;
    }

    /**
     * Get the value of cart
     */
    public function getCart() {
        return $this->cart;
    }

    /**
     * Set the value of cart
     *
     * @return  self
     */
    public function setCart($cart) {
        $this->cart = $cart;

        return $this;
    }

    public function getInventories() {
        return $this->cart->inventories()->whereIn('inventories.id', $this->item_selected)->with('product')->get();
    }

    /**
     * Get the value of item_selected
     */
    public function getItemSelected() {
        return $this->item_selected;
    }

    /**
     * Set the value of item_selected
     *
     * @return  self
     */
    public function setItemSelected($item_selected) {
        $this->item_selected = $item_selected;

        return $this;
    }

    /**
     * Get the value of order_voucher_id
     */
    public function getOrderVoucherId() {
        return $this->order_voucher_id;
    }

    /**
     * Set the value of order_voucher_id
     *
     * @return  self
     */
    public function setOrderVoucherId($order_voucher_id) {
        $this->order_voucher_id = $order_voucher_id;

        return $this;
    }

    /**
     * Get the value of order_voucher
     */
    public function getOrderVoucher() {
        if ($this->order_voucher) return $this->order_voucher;
        if(!$this->order_voucher_id) return $this->order_voucher;
        $this->order_voucher = Voucher::find($this->order_voucher_id);
        return $this->order_voucher;
    }
}
