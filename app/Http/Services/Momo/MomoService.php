<?php

namespace App\Http\Services\Momo;

use App\Models\Order;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use MService\Payment\AllInOne\Processors\CaptureMoMo;
use MService\Payment\AllInOne\Processors\QueryStatusTransaction;
use MService\Payment\AllInOne\Processors\RefundMoMo;
use MService\Payment\AllInOne\Processors\RefundStatus;
use MService\Payment\Shared\SharedModels\Environment;
use MService\Payment\Shared\SharedModels\MomoEndpoints;
use MService\Payment\Shared\SharedModels\PartnerInfo;
use MService\Payment\Shared\Utils\MoMoException;

class MomoService {
    public static function selectEnv($target = "dev", $endpoint = '/v2/gateway/api/create') {
        switch ($target) {
            case "dev":
                $devInfo = new PartnerInfo(env('DEV_ACCESS_KEY'), env('DEV_PARTNER_CODE'), env('DEV_SECRET_KEY'));
                $dev = new Environment("https://test-payment.momo.vn".$endpoint, $devInfo, env('DEV'), handlers: [new StreamHandler(storage_path('log/momo.log'), Logger::DEBUG)]);
                return $dev;

            case "prod":
                $productionInfo = new PartnerInfo(env('PROD_ACCESS_KEY'), env('PROD_PARTNER_CODE'), env('PROD_SECRET_KEY'));
                $production = new Environment(env('PROD_MOMO_ENDPOINT') . $endpoint, $productionInfo, env('PROD'));
                return $production;

            default:
                throw new MoMoException("MoMo doesnt provide other environment: dev and prod");
        }
    }

    public static function checkout(Order $order) {
        $env = MomoService::selectEnv('dev');
        $requestId = time() . "";
        $redirectUrl = route('client.auth.profile.index', ['tab' => 'order-list']);
        return CaptureMoMo::process($env, time(), "Pay With MoMo", $order->total, base64_encode("theciu"), $requestId, route('webhook.payment.momo', $order->id), $redirectUrl)->getPayUrl();
    }

    public static function refund() {
        $env = MomoService::selectEnv('dev', MomoEndpoints::REFUND);
        $requestId = time() + 60;
        $orderId = time();
        return RefundMoMo::process($env, $orderId, $requestId, 30000, 2841554570);
    }

    public static function queryStatusTransaction() {
        $env = MomoService::selectEnv('dev', MomoEndpoints::QUERY_STATUS_TRANSACTION);
        $requestId = time() + 60;
        $orderId = time();
        return QueryStatusTransaction::process($env, $orderId, $requestId);
    }

    public static function getServiceEndpoint($service) {
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
