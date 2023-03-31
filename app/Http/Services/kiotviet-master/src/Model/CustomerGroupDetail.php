<?php declare(strict_types=1);

namespace VienThuong\KiotVietClient\Model;

class CustomerGroupDetail extends BaseModel
{
    /**
     * @var int
     */
    private $customerId;

    /**
     * @var int
     */
    private $groupId;

    /**
     * Get the value of customerId
     *
     * @return  int
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * Set the value of customerId
     *
     * @param  int  $customerId
     *
     * @return  self
     */
    public function setCustomerId(int $customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get the value of groupId
     *
     * @return  int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set the value of groupId
     *
     * @param  int  $groupId
     *
     * @return  self
     */
    public function setGroupId(int $groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }
}
