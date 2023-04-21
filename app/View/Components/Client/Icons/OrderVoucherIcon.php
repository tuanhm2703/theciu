<?php

namespace App\View\Components\Client\Icons;

use Illuminate\View\Component;

class OrderVoucherIcon extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.client.icons.order-voucher-icon');
    }
}
