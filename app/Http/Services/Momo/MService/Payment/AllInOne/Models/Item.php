<?php

namespace MService\Payment\AllInOne\Models;

class Item {
    private $id;
    private $name;
    private $description;
    private $category;
    private $imageUrl;
    private $manufacturer;
    private $price;
    private $currency = 'VND';
    private $quantity;
    private $unit;
    private $totalPrice;
    private $taxAmount;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of imageUrl
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set the value of imageUrl
     *
     * @return  self
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get the value of manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set the value of manufacturer
     *
     * @return  self
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of currency
     *
     * @return  self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set the value of unit
     *
     * @return  self
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get the value of totalPrice
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set the value of totalPrice
     *
     * @return  self
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get the value of taxAmount
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * Set the value of taxAmount
     *
     * @return  self
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }
}
