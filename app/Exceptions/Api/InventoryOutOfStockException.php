<?php

namespace App\Exceptions\Api;

use App\Enums\ApiExceptionCode;
use App\Models\Inventory;
use App\Responses\Api\BaseResponse;
use Exception;
use Throwable;

class InventoryOutOfStockException extends Exception
{
    public Inventory $inventory;

    function __construct(Inventory $inventory, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->inventory = $inventory;
    }


    public function render()
    {
        return BaseResponse::error([
            'message' => "Sản phẩm không đủ tồn kho",
            'inventory_id' => $this->inventory->id,
            'code' => ApiExceptionCode::INVENTORY_OUT_OF_STOCK
        ], 400);
    }
}
