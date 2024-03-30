<?php

namespace App\Traits\Scopes;

use App\Enums\CategoryType;
use App\Enums\StatusType;
use Illuminate\Support\Facades\DB;

trait ProductScope {
    public function scopeFindBySlug($q, $slug) {
        return $q->where('products.slug', $slug);
    }

    public function scopeDontHavePromotion($q) {
        $now = now();
        return $q->whereDoesntHave('promotions', function ($q) use ($now) {
            return $q->whereNotNull('promotions.from')->whereNotNull('promotions.to')->where(function ($q) use ($now) {
                $q->whereRaw("'$now' between promotions.from and promotions.to")->orWhere('promotions.from', '>=', now());
            });
        });
    }
    public function scopeDontHaveCombo($q) {
        return $q->whereDoesntHave('combos', function($q) {
            $q->whereNotNull('combos.begin')->whereNotNull('combos.end')->where(function ($q) {
                $q->whereRaw("now() between combos.begin and combos.end")->orWhere('combos.begin', '>=', now());
            });
        });
    }

    public function scopeNewArrival($q) {
        return $q->orderBy('created_at', 'desc');
    }

    public function scopeBestSeller($q) {
        return $q->whereHas('other_categories', function ($q) {
            $q->where('categories.type', CategoryType::BEST_SELLER);
        })->orderBy('created_at', 'desc');
    }

    public function scopeAvailable($q) {
        return $q->where(function ($q) {
            $q->whereHas('inventories', function ($q) {
                $q->where('stock_quantity', '>', 0)->where('inventories.status', 1);
            })->orWhere('products.is_reorder', 1);
        })->whereHas('categories')->whereHas('images')->where('visible', 1);
    }
    public function scopeAvailableCannotView($q) {
        return $q->where(function ($q) {
            $q->whereHas('inventories', function ($q) {
                $q->where('stock_quantity', '>', 0)->where('inventories.status', 1);
            })->orWhere('products.is_reorder', 1);
        })->whereHas('images');
    }
    public function scopeHasAvailablePromotions($q) {
        return $q->whereHas('promotions', function ($q) {
            $q->available();
        });
    }
    public function scopeHasAvailableCombos($q) {
        return $q->whereHas('combos', function ($q) {
            $q->available();
        });
    }

    public function scopeHasIncommingpromotions($q) {
        return $q->whereHas('promotions', function($q) {
            $q->incomming();
        });
    }

    public function scopeWithNeededProductCardData($q) {
        return $q->available()->with(
            'image:path,imageable_id,imageable_type,id,name',
            'available_flash_sales',
            'inventories.image:id,path,imageable_id,name,imageable_type',
            'categories:id,name,parent_id,status,slug,type',
            'inventories')->select('products.id', 'products.slug', 'products.name');
    }

    public function scopeAddSalePrice($q) {
        /* Adding a column called `sale_price` to the query. */
        return $q->leftJoin('promotion_product', function ($q) {
            $q->on('promotion_product.product_id', 'products.id');
        })->leftJoin('promotions', function ($q) {
            $q->on('promotions.id', 'promotion_product.promotion_id')
                ->where('promotions.status', StatusType::ACTIVE)
                ->whereRaw("now() between `promotions`.`from` and `promotions`.`to`")
                ->whereNotNull('promotions.from')->whereNotNull('promotions.to');
        })->leftJoin('inventories', function ($q) {
            $q->on('inventories.product_id', 'products.id')
                ->where('inventories.stock_quantity', '>', 0)->where(function ($q) {
                    $q->whereRaw("(now() not between inventories.promotion_from and inventories.promotion_to)")
                        ->orWhereNull('inventories.promotion_from')
                        ->orWhereNull('inventories.promotion_to')
                        ->orWhere('inventories.promotion_status', 0);
                })->whereNull('inventories.deleted_at');
        })->leftJoin('inventories as promotion_inventories', function ($q) {
            $q->on('promotion_inventories.product_id', 'products.id')
                ->where('promotion_inventories.stock_quantity', '>', 0)
                ->where('promotion_inventories.promotion_status', 1)
                ->whereRaw('now() between promotion_inventories.promotion_from and promotion_inventories.promotion_to')
                ->whereNull('promotion_inventories.deleted_at');
        })->addSelect(DB::raw('case when promotions.id is null then min(inventories.price) else min(promotion_inventories.promotion_price) end as sale_price'))->groupBy('products.id');
    }

    public function scopeAddSales() {

    }
    public function scopeFilterByPriceRange($q, $min, $max) {
        $min = $min ? $min : 0;
        $max = $max ? $max : 10000000000;
        return $q->addSalePrice()->having('sale_price', '>=', $min)->having('sale_price', '<=', $max);
    }
}
