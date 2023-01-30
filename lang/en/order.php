<?php

return [
    'order_status' => [
        'waiting_to_pick' => 'Waiting to pick',
        'wait_to_accept' => 'Wait to accept',
        'picking' => 'Picking',
        'delivering' => 'Delivering',
        'delivered' => 'Delivered',
        'canceled' => 'Canceled',
        'return' => 'Return',
    ],
    'order_sub_status' => [
        'preparing' => 'Preparing',
        'finish_packaging' => 'Finish packaging',
    ],
    'cancel_reasons' => [
        'out_of_stock' => 'Out of stock',
        'cannot_prepare_in_time' => 'Cannot prepare in time',
        'shipping_address_invalid' => 'Shipping address invalid',
        'other' => 'Other'
    ]
];
