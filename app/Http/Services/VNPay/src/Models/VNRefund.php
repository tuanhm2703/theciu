<?php

namespace App\Http\Services\VNPay\src\Models;

use GuzzleHttp\Client;

class VNRefund {
    private $txnRef;
    private $amount;
    private $orderInfo;
    private $createBy;
    private $transNo;
    private CreateRefundRequest $createRefundRequest;
    public function __construct($txnRef, $amount, $orderInfo, $createBy, $transNo) {
        $this->txnRef = $txnRef;
        $this->amount = $amount * 100;
        $this->orderInfo = $orderInfo;
        $this->createBy = $createBy;
        $this->transNo = $transNo;
    }

    public static function process($order_number, $amount, $orderInfo, $createBy, $transNo) {
        $payment = new VNRefund($order_number, $amount, $orderInfo, $createBy, $transNo);
        return $payment->execute();
    }

    public function execute() {
        $request = $this->getCreateRefundRequest();
        $secureHash = $request->getVnpSecureHash();
        $data = $request->getRequestData();
        $data[Param::SECURE_HASH] = $secureHash;
        return $this->sendRefundRequest($data);
    }

    private function sendRefundRequest($data) {
        $client = new Client();
        $response = $client->post(config('services.vnpay.refund_url'), [
            'body' => json_encode($data)
        ]);
        \Log::info((string) $response->getBody());
        $data = json_decode((string) $response->getBody());
        if($data->{Param::RESPONSE_CODE} != '00') {
            return false;
        }
        return true;
    }

    public function setCreateRefundRequest() {
        $this->createRefundRequest = new CreateRefundRequest([
            Param::AMOUNT => $this->amount,
            Param::TXN_REF => $this->txnRef,
            Param::CREATE_BY => $this->createBy,
            Param::ORDER_INFO => $this->orderInfo,
            Param::TRANSACTION_NUMBER => $this->transNo
        ]);
        $this->createRefundRequest->generateRequestData();
    }

    public function getCreateRefundRequest() {
        if(isset($this->createRefundRequest)) {
            return $this->createRefundRequest;
        }
        $this->setCreateRefundRequest();
        return $this->createRefundRequest;
    }

}
