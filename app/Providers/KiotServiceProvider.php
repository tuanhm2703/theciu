<?php

namespace App\Providers;

use App\Events\Kiot\OrderCanceledEvent;
use App\Events\Kiot\OrderCreatedEvent;
use App\Events\Kiot\OrderDeliveredEvent;
use App\Events\Kiot\OrderWaitToPickEvent;
use App\Listeners\Kiot\OrderCanceledListener;
use App\Listeners\Kiot\OrderCreatedListener;
use App\Listeners\Kiot\OrderDeliveredListener;
use App\Listeners\Kiot\OrderWaitToPickListener;
use App\Models\Customer;
use App\Models\Order;
use App\Observers\Kiot\CustomerObserver;
use App\Observers\Kiot\OrderObserver;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class KiotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') == 'prod') {
            Event::listen(
                OrderCreatedEvent::class,
                [OrderCreatedListener::class, 'handle']
            );
            Event::listen(
                OrderCanceledEvent::class,
                [OrderCanceledListener::class, 'handle']
            );
            Event::listen(
                OrderDeliveredEvent::class,
                [OrderDeliveredListener::class, 'handle']
            );
            Event::listen(
                OrderWaitToPickEvent::class,
                [OrderWaitToPickListener::class, 'handle']
            );
            Order::observe(OrderObserver::class);
            $this->loadRoutesFrom(__DIR__ . '/../../routes/kiot/Webhook.php');
        }
        Customer::observe(CustomerObserver::class);
    }
}
