<?php


namespace MService\Payment\AllInOne\Models;

use MService\Payment\Shared\Constants\RequestType;

class CaptureMoMoRequest extends AIORequest
{
    private $partnerName;
    private $storeId;
    private $items;
    public function __construct(array $params = array())
    {
        parent::__construct($params);
        $this->setRequestType(RequestType::CAPTURE_MOMO_WALLET);
    }

    public function setPartnerName($partnerName) {
        $this->partnerName = $partnerName;
    }

    public function getPartnerName() {
        return $this->partnerName;
    }

    public function setStoreId($storeId) {
        $this->storeId = $storeId;
    }

    public function getStoreId() {
        return $this->storeId;
    }

    public function setItems($items) {
        $this->items = $items;
    }

    public function getItem() {
        return $this->items;
    }

}
