<?php

namespace App\Providers;

use App\Events\Kiot\OrderCanceledEvent;
use App\Events\Kiot\OrderCreatedEvent;
use App\Listeners\Kiot\OrderCanceledListener;
use App\Listeners\Kiot\OrderCreatedListener;
use App\Models\Customer;
use App\Models\Order;
use App\Observers\Kiot\CustomerObserver;
use App\Observers\Kiot\OrderObserver;
use Illuminate\Support\ServiceProvider;

class KiotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

     protected $listen = [
        OrderCreatedEvent::class => [
            OrderCreatedListener::class
        ],
        OrderCanceledEvent::class => [
            OrderCanceledListener::class
        ]
    ];

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
        Customer::observe(CustomerObserver::class);
        Order::observe(OrderObserver::class);
        $this->loadRoutesFrom(__DIR__.'/../../routes/kiot/Webhook.php');
    }
}
