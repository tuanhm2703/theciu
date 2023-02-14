<?php

namespace App\Providers;

use App\Events\OrderCanceled;
use App\Events\OrderCreatedEvent;
use App\Events\ProductCreated;
use App\Listeners\OrderCanceledListener;
use App\Listeners\OrderCreatedListener;
use App\Listeners\ProductCreated as ListenersProductCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        OrderCanceled::class => [
            OrderCanceledListener::class
        ],
        OrderCreatedEvent::class => [
            OrderCreatedListener::class
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProductCreated::class => [
            ListenersProductCreated::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
