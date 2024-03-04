<?php


namespace MService\Payment\AllInOne\Processors;

use Illuminate\Support\Facades\App;
use MService\Payment\AllInOne\Models\PayATMRequest;
use MService\Payment\AllInOne\Models\PayATMResponse;
use MService\Payment\Shared\Constants\Parameter;
use MService\Payment\Shared\Constants\RequestType;
use MService\Payment\Shared\SharedModels\Environment;
use MService\Payment\Shared\Utils\Converter;
use MService\Payment\Shared\Utils\Encoder;
use MService\Payment\Shared\Utils\HttpClient;
use MService\Payment\Shared\Utils\MoMoException;
use MService\Payment\Shared\Utils\Process;

class PayATM extends Process
{

    public function __construct(Environment $environment)
    {
        parent::__construct($environment);
    }

    public static function process(Environment $env, $orderId, $orderInfo, string $amount, $extraData, $requestId, $ipnUrl, $redirectUrl)
    {
        $payATM = new PayATM($env);

        try {
            $payATMRequest = $payATM->createPayATMRequest($orderId, $orderInfo, $amount, $extraData, $requestId, $ipnUrl, $redirectUrl);
            $payATMResponse = $payATM->execute($payATMRequest);

            return $payATMResponse;

        } catch (MoMoException $exception) {
            \log::error(json_encode($exception));
            $payATM->logger->error($exception->getErrorMessage());
        }
    }

    public function createPayATMRequest($orderId, $orderInfo, string $amount, $extraData, $requestId, $ipnUrl, $redirectUrl): PayATMRequest
    {
        $accessKey = $this->getPartnerInfo()->getAccessKey();
        $partnerCode = $this->getPartnerInfo()->getPartnerCode();
        $requestType = RequestType::PAY_WITH_ATM;
        $rawData = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=$requestType";

        $signature = Encoder::hashSha256($rawData, $this->getPartnerInfo()->getSecretKey());

        $this->logger->debug('[PayATMRequest] rawData: ' . $rawData
                                         . ', [Signature] -> ' . $signature);

        $arr = array(
            Parameter::PARTNER_CODE => $this->getPartnerInfo()->getPartnerCode(),
            Parameter::REQUEST_TYPE => $requestType,
            Parameter::IPN_URL => $ipnUrl,
            Parameter::REDIRECT_URL => $redirectUrl,
            Parameter::ORDER_ID => $orderId,
            Parameter::AMOUNT => $amount,
            Parameter::LANG => App::getLocale(),
            Parameter::ORDER_INFO => $orderInfo,
            Parameter::REQUEST_ID => $requestId,
            Parameter::EXTRA_DATA => $extraData,
            Parameter::SIGNATURE => $signature,
            Parameter::ORDER_GROUP_ID => env('MOMO_ATM_GROUP_ID')
        );

        return new PayATMRequest($arr);
    }

    public function execute($payATMRequest)
    {
        try {
            $data = Converter::objectToJsonStrNoNull($payATMRequest);

            $response = HttpClient::HTTPPost($this->getEnvironment()->getMomoEndpoint(), $data, $this->getLogger());

            if ($response->getStatusCode() != 200) {
                throw new MoMoException('[PayATMResponse][' . $payATMRequest->getOrderId() . '] -> Error API');
            }

            $payATMResponse = new PayATMResponse(json_decode($response->getBody(), true));

            return $this->checkResponse($payATMResponse);

        } catch (MoMoException $exception) {
            $this->logger->error($exception->getErrorMessage());
        }
    }

    public function checkResponse(PayATMResponse $payATMResponse)
    {
        try {

            //check signature
            $rawHash = Parameter::PARTNER_CODE . "=" . $payATMResponse->getPartnerCode() .
                "&" . Parameter::ACCESS_KEY . "=" . $payATMResponse->getAccessKey() .
                "&" . Parameter::REQUEST_ID . "=" . $payATMResponse->getRequestId() .
                "&" . Parameter::PAY_URL . "=" . $payATMResponse->getPayUrl() .
                "&" . Parameter::ERROR_CODE . "=" . $payATMResponse->getErrorCode() .
                "&" . Parameter::ORDER_ID . "=" . $payATMResponse->getOrderId() .
                "&" . Parameter::MESSAGE . "=" . $payATMResponse->getMessage() .
                "&" . Parameter::LOCAL_MESSAGE . "=" . $payATMResponse->getLocalMessage() .
                "&" . Parameter::REQUEST_TYPE . "=" . $payATMResponse->getRequestType();

            $signature = hash_hmac("sha256", $rawHash, $this->getPartnerInfo()->getSecretKey());

            $this->logger->info("[PayATMResponse] rawData: " . $rawHash
                . ", [Signature] -> " . $signature
                . ", [MoMoSignature] -> " . $payATMResponse->getSignature());

            if ($signature == $payATMResponse->getSignature())
                return $payATMResponse;
            else
                throw new MoMoException("Wrong signature from MoMo side - please contact with us");
        } catch (MoMoException $exception) {
            $this->logger->error('[PayATMResponse][' . $payATMResponse->getOrderId() . '] -> ' . $exception->getErrorMessage());
        }
        return $payATMResponse;
    }
}
