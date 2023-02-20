<?php

namespace App\Http\Services\VNPay\src\Models;

class IPNUrl {
    private CreateIpnUrlRequest $createIpnUrlRequest;
    private $bankCod;
    private $transNo;
    private $transStatus;
    private $amount;
    private $orderInfo;
    private $txnRef;
    private $responseCode;

    public function __construct($amount, $orderInfo, $bankCod, $transNo, $transStatus, $txnRef, $responseCode) {
        $this->amount = $amount;
        $this->orderInfo = $orderInfo;
        $this->bankCod = $bankCod;
        $this->transNo = $transNo;
        $this->transStatus = $transStatus;
        $this->txnRef = $txnRef;
        $this->responseCode = $responseCode;
    }

    public static function process($amount, $orderInfo, $bankCod, $transNo, $transStatus, $txnRef, $responseCode) {
        $payment = new IPNUrl($amount, $orderInfo, $bankCod, $transNo, $transStatus, $txnRef, $responseCode);
        return $payment->execute();
    }

    public  function execute() {
        return $this->getCreateIpnUrlRequest()->getVnpUrl();
    }

    public function setCreateIpnUrlRequest() {
        $this->createIpnUrlRequest = new CreateIpnUrlRequest([
            Param::AMOUNT => $this->amount,
            Param::BANK_COD => $this->bankCod,
            Param::ORDER_INFO => $this->orderInfo,
            Param::TRANSACTION_NUMBER => $this->transNo,
            Param::TXN_REF => $this->txnRef,
            Param::RESPONSE_CODE => $this->responseCode,
            Param::TRANSACTION_STATUS => $this->transStatus,
            Param::TXN_REF => $this->txnRef
        ]);
        $this->createIpnUrlRequest->generateRequestData();
    }

    public function getCreateIpnUrlRequest(): CreateIpnUrlRequest {
        if (!isset($this->createIpnUrlRequest)) {
            $this->setCreateIpnUrlRequest();
        }
        return $this->createIpnUrlRequest;
    }
}
