<?php

namespace App\Http\Services\Momo;

use App\Models\Order;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use MService\Payment\AllInOne\Processors\CaptureMoMo;
use MService\Payment\Shared\SharedModels\Environment;
use MService\Payment\Shared\SharedModels\PartnerInfo;
use MService\Payment\Shared\Utils\MoMoException;

class MomoService {
    public static function selectEnv($target = "dev") {
        switch ($target) {
            case "dev":
                $devInfo = new PartnerInfo(env('DEV_ACCESS_KEY'), env('DEV_PARTNER_CODE'), env('DEV_SECRET_KEY'));
                $dev = new Environment('https://test-payment.momo.vn/gw_payment/transactionProcessor', $devInfo, env('DEV'), handlers: [new StreamHandler(storage_path('log/momo.log'), Logger::DEBUG)]);
                return $dev;

            case "prod":
                $productionInfo = new PartnerInfo(env('PROD_ACCESS_KEY'), env('PROD_PARTNER_CODE'), env('PROD_SECRET_KEY'));
                $production = new Environment(env('PROD_MOMO_ENDPOINT') . "/gw_payment/transactionProcessor", $productionInfo, env('PROD'));
                return $production;

            default:
                throw new MoMoException("MoMo doesnt provide other environment: dev and prod");
        }
    }

    public static function checkout(Order $order) {
        $env = MomoService::selectEnv('dev');
        $requestId = time() . "";
        $redirectUrl = route('client.auth.profile.index', ['tab' => 'order-list']);
        return CaptureMoMo::process($env, (string) $order->order_number, "Pay With MoMo", $order->total, "theciu", $requestId, "https://beta.theciu.vn", $redirectUrl)->getPayUrl();
    }
}
