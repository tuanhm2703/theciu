<?php

namespace App\Http\Services\VNPay\src\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class AIORequest {
    private string $vnp_Version = '2.1.0';
    private string $vnp_Url;
    protected string $vnp_ReturnUrl;
    private string $vnp_TmnCode = ""; //Mã website tại VNPAY
    private string $vnp_HashSecret = ""; //Chuỗi bí mật
    protected string $vnp_SecureHash;

    protected string $vnp_Command;

    protected string $vnp_TxnRef; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    protected string $vnp_OrderInfo;
    protected string $vnp_OrderTyp;
    protected string $vnp_Amount;
    protected string $vnp_Locale;
    protected string $vnp_BankCod;
    protected string $vnp_IpAddr;
    protected string $vnp_CurrCode = 'VND';

    protected $vnp_CreateDate;

    protected array $requestData;

    public function __construct(array $properties) {
        $this->vnp_TmnCode = config('services.vnpay.tmn_code');
        $this->vnp_HashSecret = config('services.vnpay.hash_secret');
        $this->vnp_Url = config('services.vnpay.url');
        $this->vnp_IpAddr = Request::ip();
        $this->vnp_Locale = App::getFallbackLocale();
        $this->mapProperties($properties);
    }

    public function toArray() {
        $data = [];
        foreach (get_object_vars($this) as $key => $value) {
            $ucFirst = ucfirst(\Str::camel($key));
            $getter = 'get' . $ucFirst;
            if (property_exists($this, $key) && method_exists($this, $getter)) {
                if(!in_array($key, [
                    Param::URL,
                    PARAM::HASHSECRET
                ])) {
                    $data[$key] = $this->$getter();
                }
            }
        }
        return $data;
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
     * Get the value of vnp_Version
     */
    public function getVnpVersion(): string {
        return $this->vnp_Version;
    }

    /**
     * Set the value of vnp_Version
     *
     * @return  self
     */
    public function setVnpVersion(string $vnp_Version) {
        $this->vnp_Version = $vnp_Version;

        return $this;
    }

    /**
     * Get the value of vnp_Url
     */
    public function getVnpUrl(): string {
        return $this->vnp_Url;
    }

    /**
     * Set the value of vnp_Url
     *
     * @return  self
     */
    public function setVnpUrl(string $vnp_Url) {
        $this->vnp_Url = $vnp_Url;

        return $this;
    }

    /**
     * Get the value of vnp_ReturnUrl
     */
    public function getVnpReturnUrl(): string {
        return $this->vnp_ReturnUrl;
    }

    /**
     * Set the value of vnp_ReturnUrl
     *
     * @return  self
     */
    public function setVnpReturnUrl(string $vnp_ReturnUrl) {
        $this->vnp_ReturnUrl = $vnp_ReturnUrl;

        return $this;
    }

    /**
     * Get the value of vnp_TmnCode
     */
    public function getVnpTmnCode(): string {
        return $this->vnp_TmnCode;
    }

    /**
     * Set the value of vnp_TmnCode
     *
     * @return  self
     */
    public function setVnpTmnCode(string $vnp_TmnCode) {
        $this->vnp_TmnCode = $vnp_TmnCode;

        return $this;
    }

    /**
     * Get the value of vnp_HashSecret
     */
    public function getVnpHashSecret(): string {
        return $this->vnp_HashSecret;
    }

    /**
     * Set the value of vnp_HashSecret
     *
     * @return  self
     */
    public function setVnpHashSecret(string $vnp_HashSecret) {
        $this->vnp_HashSecret = $vnp_HashSecret;

        return $this;
    }

    /**
     * Get the value of vnp_Command
     */
    public function getVnpCommand(): string {
        return $this->vnp_Command;
    }

    /**
     * Set the value of vnp_Command
     *
     * @return  self
     */
    public function setVnpCommand(string $vnp_Command) {
        $this->vnp_Command = $vnp_Command;

        return $this;
    }

    /**
     * Get the value of vnp_TxnRef
     */
    public function getVnpTxnRef(): string {
        return $this->vnp_TxnRef;
    }

    /**
     * Set the value of vnp_TxnRef
     *
     * @return  self
     */
    public function setVnpTxnRef(string $vnp_TxnRef) {
        $this->vnp_TxnRef = $vnp_TxnRef;

        return $this;
    }

    /**
     * Get the value of vnp_OrderInfo
     */
    public function getVnpOrderInfo(): string {
        return $this->vnp_OrderInfo;
    }

    /**
     * Set the value of vnp_OrderInfo
     *
     * @return  self
     */
    public function setVnpOrderInfo(string $vnp_OrderInfo) {
        $this->vnp_OrderInfo = $vnp_OrderInfo;

        return $this;
    }

    /**
     * Get the value of vnp_OrderTyp
     */
    public function getVnpOrderTyp() {
        return $this->vnp_OrderTyp;
    }

    /**
     * Set the value of vnp_OrderTyp
     *
     * @return  self
     */
    public function setVnpOrderTyp(int $vnp_OrderTyp) {
        $this->vnp_OrderTyp = $vnp_OrderTyp;

        return $this;
    }

    /**
     * Get the value of vnp_Amount
     */
    public function getVnpAmount(): int {
        return $this->vnp_Amount;
    }

    /**
     * Set the value of vnp_Amount
     *
     * @return  self
     */
    public function setVnpAmount(int $vnp_Amount) {
        $this->vnp_Amount = $vnp_Amount;

        return $this;
    }

    /**
     * Get the value of vnp_Locale
     */
    public function getVnpLocale() {
        return $this->vnp_Locale;
    }

    /**
     * Set the value of vnp_Locale
     *
     * @return  self
     */
    public function setVnpLocale($vnp_Locale) {
        $this->vnp_Locale = $vnp_Locale;

        return $this;
    }

    /**
     * Get the value of vnp_BankCod
     */
    public function getVnpBankCod() {
        return $this->vnp_BankCod;
    }

    /**
     * Set the value of vnp_BankCod
     *
     * @return  self
     */
    public function setVnpBankCod(string $vnp_BankCod) {
        $this->vnp_BankCod = $vnp_BankCod;

        return $this;
    }

    /**
     * Get the value of vnp_SecureHash
     */
    public function getVnpSecureHash(): string {
        return $this->vnp_SecureHash;
    }

    /**
     * Set the value of vnp_SecureHash
     *
     * @return  self
     */
    public function setVnpSecureHash(array $data) {
        $i = 0;
        $hashData = '';
        $query = '';
        foreach ($data as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $this->setVnpUrl($this->getVnpUrl() . '?' . $query);
        $this->vnp_SecureHash =   hash_hmac('sha512', $hashData, $this->getVnpHashSecret()); //
        $this->setVnpUrl($this->getVnpUrl() . 'vnp_SecureHash=' . $this->vnp_SecureHash);

        return $this;
    }

    public function getRequestData() {
        return $this->requestData;
    }

    /**
     * Get the value of vnp_CreateDate
     */
    public function getVnpCreateDate()
    {
        return $this->vnp_CreateDate;
    }

    /**
     * Set the value of vnp_CreateDate
     *
     * @return  self
     */
    public function setVnpCreateDate($vnp_CreateDate)
    {
        $this->vnp_CreateDate = $vnp_CreateDate;
        return $this;
    }

    public function generateRequestData() {
        $data = $this->toArray();
        ksort($data);
        $this->setVnpSecureHash($data);
        $this->requestData = $data;
    }

    /**
     * Get the value of vnp_CurrCode
     */
    public function getVnpCurrCode()
    {
        return $this->vnp_CurrCode;
    }

    /**
     * Set the value of vnp_CurrCode
     *
     * @return  self
     */
    public function setVnpCurrCode($vnp_CurrCode)
    {
        $this->vnp_CurrCode = $vnp_CurrCode;

        return $this;
    }

    /**
     * Get the value of vnp_IpAddr
     */
    public function getVnpIpAddr()
    {
        return $this->vnp_IpAddr;
    }

    /**
     * Set the value of vnp_IpAddr
     *
     * @return  self
     */
    public function setVnpIpAddr($vnp_IpAddr)
    {
        $this->vnp_IpAddr = $vnp_IpAddr;

        return $this;
    }
}
