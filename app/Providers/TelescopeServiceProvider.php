<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        // Telescope::night();
        Telescope::tag(function (IncomingEntry $entry) {
            if ($entry->type === 'request') {
                $url = url()->current();
                $payload = $entry->content['payload'];
                if (preg_match('/shipping\/([a-z])/', $url) && preg_match('/([a-z])\/webhook/', $url)) {
                    $order_number = null;
                    $shipping_order_number = null;
                    if(isset($payload['ClientOrderCode'])) {
                        $shipping_order_number = $payload['OrderCode'];
                    }
                    if(isset($payload['ClientOrderCode'])) {
                        $order_number = substr($payload['ClientOrderCode'], 1);
                    }
                    if(isset($payload['label_id'])) {
                        $shipping_order_number = $payload['label_id'];
                    }
                    if(isset($payload['partner_id'])) {
                        $order_number = substr($payload['partner_id'], 1);
                    }
                    return ['shipping_webhook', "shipping_webhook:$order_number", "shipping_webhook:$shipping_order_number"];
                }
            }

            return [];
        });

        $this->hideSensitiveRequestDetails();

        Telescope::filter(function (IncomingEntry $entry) {
            return true;
            if ($this->app->environment('local')) {
                return true;
            }

            return $entry->isReportableException() ||
                $entry->isFailedRequest() ||
                $entry->isFailedJob() ||
                $entry->isScheduledTask() ||
                $entry->hasMonitoredTag();
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     *
     * @return void
     */
    protected function hideSensitiveRequestDetails() {
        if ($this->app->environment('local')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     *
     * @return void
     */
    protected function gate() {
        Gate::define('viewTelescope', function ($user) {
            if (env('APP_ENV') == 'local' || env('APP_ENV') == 'dev') return true;
                return $user->isAdmin();
        });
    }
}
