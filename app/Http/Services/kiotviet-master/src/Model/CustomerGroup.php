<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Model;

use VienThuong\KiotVietClient\Collection\CustomerGroupDetailCollection;

class CustomerGroup extends BaseModel
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var int|null
     */
    private $createdBy;

    /**
     * @var float|null
     */
    private $discount;


    private $customerId;


    /**
     * @var CustomerGroupDetailCollection
     */
    private $customerGroupDetails;



    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return  string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string|null  $description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of createdBy
     *
     * @return  int|null
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set the value of createdBy
     *
     * @param  int|null  $createdBy
     *
     * @return  self
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get the value of customerGroupDetails
     *
     * @return  CustomerGroupDetailCollection
     */
    public function getCustomerGroupDetails()
    {
        return $this->customerGroupDetails;
    }

    /**
     * Set the value of customerGroupDetails
     *
     * @param  CustomerGroupDetailCollection  $customerGroupDetails
     *
     * @return  self
     */
    public function setCustomerGroupDetails(CustomerGroupDetailCollection $customerGroupDetails)
    {
        $this->customerGroupDetails = $customerGroupDetails;

        return $this;
    }
}
