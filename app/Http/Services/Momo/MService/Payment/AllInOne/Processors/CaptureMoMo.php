<?php

namespace MService\Payment\AllInOne\Processors;

use Illuminate\Support\Facades\App;
use MService\Payment\AllInOne\Models\CaptureMoMoRequest;
use MService\Payment\AllInOne\Models\CaptureMoMoResponse;
use MService\Payment\Shared\Constants\Parameter;
use MService\Payment\Shared\Constants\RequestType;
use MService\Payment\Shared\SharedModels\Environment;
use MService\Payment\Shared\Utils\Converter;
use MService\Payment\Shared\Utils\Encoder;
use MService\Payment\Shared\Utils\HttpClient;
use MService\Payment\Shared\Utils\MoMoException;
use MService\Payment\Shared\Utils\Process;

class CaptureMoMo extends Process {
    public function __construct(Environment $environment) {
        parent::__construct($environment);
    }

    public static function process(Environment $env, $orderId, $orderInfo, string $amount, $extraData, $requestId, $ipnUrl, $redirectUrl) {
        $captureMoMoWallet = new CaptureMoMo($env);
        try {
            $captureMoMoRequest = $captureMoMoWallet->createCaptureMoMoRequest($orderId, $orderInfo, $amount, $extraData, $requestId, $ipnUrl, $redirectUrl);
            $captureMoMoResponse = $captureMoMoWallet->execute($captureMoMoRequest);
            return $captureMoMoResponse;
        } catch (MoMoException $exception) {
            \log::error(json_encode($exception));
            $captureMoMoWallet->logger->error($exception->getErrorMessage());
        }
    }

    public function createCaptureMoMoRequest($orderId, $orderInfo, string $amount, $extraData, $requestId, $ipnUrl, $redirectUrl): CaptureMoMoRequest {
        $accessKey = $this->getPartnerInfo()->getAccessKey();
        $partnerCode = $this->getPartnerInfo()->getPartnerCode();
        $rawData = "accessKey=$accessKey&amount=$amount&extraData=$extraData&ipnUrl=$ipnUrl&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$redirectUrl&requestId=$requestId&requestType=".RequestType::CAPTURE_MOMO_WALLET;
        $signature = Encoder::hashSha256($rawData, $this->getPartnerInfo()->getSecretKey());

        $this->logger->debug('[CaptureMoMoRequest] rawData: ' . $rawData
            . ', [Signature] -> ' . $signature);
        $arr = array(
            Parameter::PARTNER_CODE => $this->getPartnerInfo()->getPartnerCode(),
            Parameter::ACCESS_KEY => $this->getPartnerInfo()->getAccessKey(),
            Parameter::REQUEST_ID => $requestId,
            Parameter::AMOUNT => $amount,
            Parameter::ORDER_ID => $orderId,
            Parameter::ORDER_INFO => $orderInfo,
            Parameter::IPN_URL => $ipnUrl,
            Parameter::REDIRECT_URL => $redirectUrl,
            Parameter::EXTRA_DATA => $extraData,
            Parameter::SIGNATURE => $signature,
            Parameter::LANG => App::getLocale(),
            Parameter::REQUEST_TYPE => RequestType::CAPTURE_MOMO_WALLET,
            Parameter::ORDER_GROUP_ID => intval(env('MOMO_CAPTURE_GROUP_ID'))
        );

        return new CaptureMoMoRequest($arr);
    }

    public function execute($captureMoMoRequest) {
        try {
            $data = Converter::objectToJsonStrNoNull($captureMoMoRequest);
            $response = HttpClient::HTTPPost($this->getEnvironment()->getMomoEndpoint(), $data, $this->getLogger());
            if ($response->getStatusCode() != 200) {
                throw new MoMoException('[CaptureMoMoResponse][' . $captureMoMoRequest->getOrderId() . '] -> Error API');
            }

            $captureMoMoResponse = new CaptureMoMoResponse(json_decode($response->getBody(), true));
            // $response = $this->checkResponse($captureMoMoResponse);
            return $captureMoMoResponse;
        } catch (MoMoException $e) {
            $this->logger->error($e->getErrorMessage());
        }
        return null;
    }

    public function checkResponse(CaptureMoMoResponse $captureMoMoResponse) {
        try {
            //check signature
            $rawHash = Parameter::PARTNER_CODE . "=" . $captureMoMoResponse->getPartnerCode() .
                "&" . Parameter::ORDER_ID . "=" . $captureMoMoResponse->getOrderId() .
                "&" . Parameter::MESSAGE . "=" . $captureMoMoResponse->getMessage() .
                "&" . Parameter::LOCAL_MESSAGE . "=" . $captureMoMoResponse->getLocalMessage() .
                "&" . Parameter::PAY_URL . "=" . $captureMoMoResponse->getPayUrl() .
                "&" . Parameter::ERROR_CODE . "=" . $captureMoMoResponse->getErrorCode() .
                "&" . Parameter::REQUEST_TYPE . "=" . $captureMoMoResponse->getRequestType();

            $signature = hash_hmac("sha256", $rawHash, $this->getPartnerInfo()->getSecretKey());
            $this->logger->info("[CaptureMoMoResponse] rawData: " . $rawHash
                . ', [Signature] -> ' . $signature
                . ', [MoMoSignature] -> ' . $captureMoMoResponse->getSignature());
            if ($signature == $captureMoMoResponse->getSignature()) {
                return $captureMoMoResponse;
            }
            else
                throw new MoMoException("Wrong signature from MoMo side - please contact with us");
        } catch (MoMoException $exception) {
            $this->logger->error('[CaptureMoMoResponse][' . $captureMoMoResponse->getOrderId() . '] -> ' . $exception->getErrorMessage());
        }
        return null;
    }
}
