<?php

namespace App\Console;

use App\Http\Services\Config\ConfigService;
use App\Jobs\SyncShopeeProductJob;
use App\Models\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Spatie\Sitemap\SitemapGenerator;
use VienThuong\KiotVietClient\Client;
use VienThuong\KiotVietClient\Resource\WebhookResource;
use VienThuong\KiotVietClient\WebhookType;

class Kernel extends ConsoleKernel {
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->call(function () {
            Order::cancelNotPaidOrder();
        })->hourly()->name('Remove unpaid order over 24h');
        $schedule->call(function () {
            $client = App::make(Client::class);
            $webhookResource = new WebhookResource($client);
            try {
                $webhooklist = $webhookResource->list()->toArray();
                foreach ($webhooklist as $webhook) {
                    try {
                        if ($webhook['otherProperties']['type'] == WebhookType::STOCK_UPDATE && $webhook['otherProperties']['isActive'] == false) {
                            $webhookResource->remove($webhook['id']);
                        }
                        $webhookResource->registerWebhook(WebhookType::STOCK_UPDATE, route('webhook.warehouse.kiotviet'), true, 'The CIU cập nhật tồn kho');
                        $webhookResource->registerWebhook(WebhookType::PRODUCT_DELETE, route('webhook.warehouse.kiotviet'), true, 'The CIU cập nhật tồn kho');
                        $webhookResource->registerWebhook(WebhookType::CUSTOMER_UPDATE, route('webhook.warehouse.kiotviet'), true, 'The CIU cập nhật khách hàng');
                    } catch (\Throwable $th) {
                        continue;
                    }
                }
            } catch (\Throwable $th) {
                Log::error($th);
            }
        })->hourly()->name("Update kiot warehouse webhook");
        $schedule->call(function() {
            SitemapGenerator::create('https://theciu.vn')->writeToFile(public_path('sitemap.xml'));
        })->twiceDaily();
        $schedule->call(function() {
            dispatch(new SyncShopeeProductJob(0, 50));
            return;
        })->weekly();
        $schedule->call(function() {
            (new ConfigService())->updateRedisKeywordsToDatabase();
        })->everyThreeHours();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
