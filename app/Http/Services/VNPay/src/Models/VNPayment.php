<?php

namespace App\Http\Services\VNPay\src\Models;

class VNPayment {
    private $command;
    private $amount;
    private $createDate;
    private $orderInfo;
    private $returnUrl;
    private $txnRef;
    private CreatePaymentRequest $createPaymentRequest;
    public function __construct($txnRef, int $amount, string $orderInfo, string $returnUrl) {
        $this->command = CommandType::PAY;
        $this->amount = $amount;
        $this->createDate = now()->format('YmdHis');
        $this->orderInfo = $orderInfo;
        $this->txnRef = $txnRef;
        $this->returnUrl = $returnUrl;
    }

    public static function process($order_number, $amount, $orderInfo, $returnUrl) {
        $payment = new VNPayment($order_number, $amount, $orderInfo, $returnUrl);
        return $payment->execute();
    }

    public  function execute() {
        return $this->getCreatePaymentRequest()->getVnpUrl();
    }

    public function setCreatePaymentRequest() {
        $this->createPaymentRequest = new CreatePaymentRequest([
            Param::AMOUNT => $this->amount,
            Param::COMMAND => $this->command,
            Param::CREATE_DATE => $this->createDate,
            Param::TXN_REF => $this->txnRef,
            Param::ORDER_INFO => $this->orderInfo,
            Param::RETURN_URL => $this->returnUrl
        ]);
        $this->createPaymentRequest->generateRequestData();
    }

    public function getCreatePaymentRequest(): CreatePaymentRequest {
        if (!isset($this->createPaymentRequest)) {
            $this->setCreatePaymentRequest();
        }
        return $this->createPaymentRequest;
    }

    public static function checkSum($data) {
        $vnp_SecureHash = $data['vnp_SecureHash'];
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, config('services.vnpay.hash_secret'));
        if ($secureHash == $vnp_SecureHash) {
            return true;
        }
        return false;
    }
}
