<?php

namespace App\Http\Services\Checkout;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Collection;

class CheckoutModel {
    private Address $address;
    private $shipping_fee;
    private $payment_method_id;
    private $cart;
    private $shipping_service_id;
    private $item_selected;
    private $order_voucher_id;
    private $order_voucher;
    private $freeship_voucher_id;
    private $freeship_voucher;
    private $service_id;
    private $note;
    private Customer $customer;
    private $accom_inventories;
    private $accom_product_inventories;
    private $additional_discount;

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

    public function createAddress() {
        if (!Address::whereId($this->address->id)->exists()) $this->address->save();
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
        if ($this->customer || customer()) {
            return $this->cart->inventories()->whereIn('inventories.id', $this->item_selected)->get();
        } else {
            return $this->cart->inventories;
        }
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
        if (!$this->order_voucher_id) return $this->order_voucher;
        $this->order_voucher = Voucher::find($this->order_voucher_id);
        return $this->order_voucher;
    }

    /**
     * Get the value of freeship_voucher_id
     */
    public function getFreeshipVoucherId() {
        return $this->freeship_voucher_id;
    }

    /**
     * Set the value of freeship_voucher_id
     *
     * @return  self
     */
    public function setFreeshipVoucherId($freeship_voucher_id) {
        $this->freeship_voucher_id = $freeship_voucher_id;

        return $this;
    }

    /**
     * Get the value of order_voucher
     */
    public function getFreeshipVoucher() {
        if ($this->freeship_voucher) return $this->freeship_voucher;
        if (!$this->freeship_voucher_id) return $this->freeship_voucher;
        $this->freeship_voucher = Voucher::find($this->freeship_voucher_id);
        return $this->freeship_voucher;
    }

    /**
     * Get the value of service_id
     */
    public function getServiceId() {
        return $this->service_id;
    }

    /**
     * Set the value of service_id
     *
     * @return  self
     */
    public function setServiceId($service_id) {
        $this->service_id = $service_id;

        return $this;
    }

    /**
     * Get the value of note
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * Set the value of note
     *
     * @return  self
     */
    public function setNote($note) {
        $this->note = $note;

        return $this;
    }

    /**
     * Get the value of customer
     */
    public function getCustomer(): Customer {
        if (!$this->customer->id) {
            $this->customer->first_name = $this->address->fullname;
        }
        return $this->customer;
    }

    /**
     * Set the value of customer
     *
     * @return  self
     */
    public function setCustomer(Customer $customer) {
        $this->customer = $customer;

        return $this;
    }
    public function getAccomInventories() {
        return $this->accom_inventories;
    }
    public function setAccomInventories(Collection $accom_inventories) {
        $this->accom_inventories = $accom_inventories;
        return $this;
    }

    /**
     * Get the value of accom_product_inventories
     */
    public function getAccomProductInventories() {
        return $this->accom_product_inventories;
    }

    /**
     * Set the value of accom_product_inventories
     *
     * @return  self
     */
    public function setAccomProductInventories($accom_product_inventories) {
        $this->accom_product_inventories = $accom_product_inventories;
        return $this;
    }

    public function getAdditionalDiscount() {
        return $this->additional_discount;
    }
    public function setAdditionalDiscount($additional_discount) {
        $this->additional_discount = $additional_discount;
        return $this;
    }
}
