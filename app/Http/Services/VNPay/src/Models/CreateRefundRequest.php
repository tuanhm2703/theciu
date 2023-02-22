<?php

namespace App\Http\Services\VNPay\src\Models;

class CreateRefundRequest extends AIORequest {
    protected $vnp_RequestId;
    protected $vnp_TransactionType = TransactionType::FULL;
    protected $vnp_CreateBy;
    protected $vnp_TransactionDate;
    protected $vnp_TransactionNo;
    public function __construct(array $properties) {
        $this->{Param::COMMAND} = CommandType::REFUND;
        parent::__construct($properties);
        $this->setVnpRequestId(time());
        $this->setVnpCreateDate(now()->format('YmdHis'));
        $this->setVnpUrl(config('services.vnpay.refund_url'));
        $this->setVnpTransactionDate(now()->format('YmdHis'));
        $this->setVnpIpAddr($_SERVER['REMOTE_ADDR']);
    }

    public function setVnpRequestId($requestId) {
        $this->vnp_RequestId = $requestId;
    }

    public function getVnpRequestId() {
        return $this->vnp_RequestId;
    }

    public function getVnpTransactionType(): string {
        return $this->vnp_TransactionType;
    }

    public function getVnpIpAddr() {
        return $this->vnp_IpAddr;
    }

    public function setVnpCreateBy(string $createBy) {
        $this->vnp_CreateBy = $createBy;
    }

    public function getVnpCreateby(): string {
        return $this->vnp_CreateBy;
    }

    public function getVnpTransactionDate(): int {
        return $this->vnp_TransactionDate;
    }

    public function setVnpTransactionDate($transactionDate) {
        $this->vnp_TransactionDate = $transactionDate;
    }

    public function getVnpTransactionNo() {
        return $this->vnp_TransactionNo;
    }
    public function setVnpTransactionNo($value) {
        $this->vnp_TransactionNo = $value;
    }

    public function generateRequestData() {
        $data = [
            $this->getVnpRequestId(),
            $this->getVnpVersion(),
            $this->getVnpCommand(),
            $this->getVnpTmnCode(),
            $this->getVnpTransactionType(),
            $this->getVnpTxnRef(),
            $this->getVnpAmount(),
            $this->getVnpTransactionNo(),
            $this->getVnpTransactionDate(),
            $this->getVnpCreateby(),
            $this->getVnpCreateDate(),
            $this->getVnpIpAddr(),
            $this->getVnpOrderInfo()
        ];
        parent::generateRequestData();
        $data = implode('|', $data);
        \Log::info("data :".$data);
        $this->vnp_SecureHash = hash_hmac('sha512', $data, $this->getVnpHashSecret());
        \Log::info($this->vnp_SecureHash);
    }
}
