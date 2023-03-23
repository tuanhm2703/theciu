<?php

namespace App\Traits\Common;

trait ProductPagingComponent {
    public $products;

    public $hasNext;

    public $page = 1;

    public $pageSize = 8;
}
