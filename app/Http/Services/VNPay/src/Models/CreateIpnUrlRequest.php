<?php

namespace App\Http\Services\VNPay\src\Models;

class CreateIpnUrlRequest extends AIORequest {
    public function __construct(array $properties)
    {
        parent::__construct($properties);
        $this->setVnpUrl(config('services.vnpay.ipn_url'));
    }

    public function getVnpBankCod(): string {
        return $this->vnp_BankCod;
    }
}
