<?php

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

class ActionIcon extends Enum {
    const ORDER_OREDRED = 'fas fa-shopping-bag';
    const ORDER_CANCELED = 'fas fa-ban';
    const ORDER_CONFIRMED = 'fas fa-clipboard-check';
    const ORDER_DELIVERING = 'fas fa-shipping-fast';
    const ORDER_DELIVERED = 'far fa-check-circle';
    const ORDER_PICKING_UP = 'fas fa-dolly';
    const CANCEL_REQUEST_CREATED = 'fa-regular fa-file-circle-question';
    const CANCEL_REQUEST_DENIED = 'fa-solid fa-circle-xmark';
    const CANCEL_REQUEST_REVERT = 'fa-solid fa-clock-rotate-left';
    const COD_CONSOLIDATION_CREATED = 'fa-solid fa-file-circle-plus';
    const COD_CONSOLIDATION_CHECKED = 'fa-solid fa-file-circle-check';
    const COD_CONSOLIDATION_TRANSFERED = 'fa-solid fa-money-bill-transfer';
    const COD_CONSOLIDATION_NOTE_UPDATED = 'fa-solid fa-pen-to-square';
    const ORDER_PAID = "fas fa-money-check-alt";
}
