<?php

return [
    'order_status' => [
        'waiting_to_pick' => 'Chờ lấy hàng',
        'wait_to_accept' => 'Chờ xác nhận',
        'picking' => 'Đang lấy hàng',
        'delivering' => 'Đang vận chuyển',
        'delivered' => 'Đã giao',
        'canceled' => 'Đã huỷ',
        'return' => 'Trả hàng',
    ],
    'order_sub_status' => [
        'preparing' => 'Đang chuẩn bị hàng',
        'finish_packaging' => 'Hoàn tất đóng gói',
    ],
    'cancel_reasons' => [
        'out_of_stock' => 'Hết hàng',
        'cannot_prepare_in_time' => 'Không chuẩn bị kịp hàng',
        'shipping_address_invalid' => 'Địa điểm giao hàng không đúng',
        'other' => 'Khác'
    ],
    'description' => [
        'checkout_description' => 'Thanh toan don hang :appName Ma don hang :orderNumber',
        'refund_description' => "Hoan tien don hang :appName :orderNumber"
    ]
];
