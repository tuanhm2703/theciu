<?php

namespace App\Http\Services\Momo;

use App\Models\Order;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use MService\Payment\AllInOne\Processors\CaptureMoMo;
use MService\Payment\AllInOne\Processors\PayATM;
use MService\Payment\AllInOne\Processors\QueryStatusTransaction;
use MService\Payment\AllInOne\Processors\RefundMoMo;
use MService\Payment\AllInOne\Processors\RefundStatus;
use MService\Payment\Shared\Constants\RequestType;
use MService\Payment\Shared\SharedModels\Environment;
use MService\Payment\Shared\SharedModels\MomoEndpoints;
use MService\Payment\Shared\SharedModels\PartnerInfo;
use MService\Payment\Shared\Utils\MoMoException;

class MomoService
{
    public static function selectEnv($target = "dev", $endpoint = '/v2/gateway/api/create')
    {
        switch ($target) {
            case "dev":
                $devInfo = new PartnerInfo(env('DEV_ACCESS_KEY'), env('DEV_PARTNER_CODE'), env('DEV_SECRET_KEY'));
                $dev = new Environment("https://test-payment.momo.vn" . $endpoint, $devInfo, 'dev', handlers: [new StreamHandler(storage_path('log/momo.log'), Logger::DEBUG)]);
                return $dev;

            case "prod":
                $productionInfo = new PartnerInfo(env('PROD_ACCESS_KEY'), env('PROD_PARTNER_CODE'), env('PROD_SECRET_KEY'));
                $production = new Environment(env('PROD_MOMO_ENDPOINT') . $endpoint, $productionInfo, 'prod');
                return $production;
            case "local":
                $devInfo = new PartnerInfo(env('DEV_ACCESS_KEY'), env('DEV_PARTNER_CODE'), env('DEV_SECRET_KEY'));
                $dev = new Environment("https://test-payment.momo.vn" . $endpoint, $devInfo, 'dev', handlers: [new StreamHandler(storage_path('log/momo.log'), Logger::DEBUG)]);
                return $dev;
            default:
                throw new MoMoException("MoMo doesnt provide other environment: dev and prod");
        }
    }

    public static function checkout(Order $order, $requestType = RequestType::PAY_WITH_ATM)
    {
        \Log::info(env('APP_ENV', 'dev'));
        $env = MomoService::selectEnv(env('APP_ENV', 'dev'));
        $requestId = time() + 60;
        $orderId = time();
        $redirectUrl = route('client.auth.profile.order.details', $order->id);
        switch ($requestType) {
            case RequestType::CAPTURE_MOMO_WALLET:
                return CaptureMoMo::process($env, $orderId, $order->getCheckoutDescription(), (int)  $order->total, base64_encode($order->order_number), $requestId, route('webhook.payment.momo', $order->id), $redirectUrl)->getPayUrl();
                break;
            case RequestType::PAY_WITH_ATM:
                return PayATM::process($env, $orderId, $order->getCheckoutDescription(), (int) $order->total, base64_encode($order->order_number), $requestId, route('webhook.payment.momo', $order->id), $redirectUrl)->getPayUrl();
                break;
        }
    }

    public static function refund($order)
    {
        $env = MomoService::selectEnv(env('APP_ENV', 'dev'), MomoEndpoints::REFUND);
        $requestId = time() + 60;
        $orderId = time();
        $description = $order->getRefundDescription();
        return RefundMoMo::process($env, $orderId, $requestId, $order->payment->amount, $order->payment->trans_id, $description);
    }

    public static function queryStatusTransaction($orderId)
    {
        $env = MomoService::selectEnv(env('APP_ENV', 'dev'), MomoEndpoints::QUERY_STATUS_TRANSACTION);
        $requestId = time() + 60;
        return QueryStatusTransaction::process($env, $orderId, $requestId);
    }

    public static function getServiceEndpoint($service)
    {
        switch ($service) {
            case 'refund':
                return MomoEndpoints::REFUND;
                break;
            case 'query-status-transaction':
                return MomoEndpoints::QUERY_STATUS_TRANSACTION;
            default:
                return '/gw_payment/transactionProcessor';
                break;
        }
    }
}
