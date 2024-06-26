<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryType;
use App\Enums\PromotionType;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreatePromotionProductRequest;
use App\Http\Requests\Admin\CreatePromotionRequest;
use App\Http\Requests\Admin\DeletePromotionRequest;
use App\Http\Requests\Admin\EditPromotionRequest;
use App\Http\Requests\Admin\UpdatePromotionRequest;
use App\Http\Requests\Admin\ViewPromotionRequest;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\PromotionProduct;
use App\Responses\Admin\BaseResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PromotionController extends Controller {
    public function index(ViewPromotionRequest $request) {
        return view('admin.pages.promotion.index');
    }

    public function show(Promotion $promotion) {
    }

    public function create(CreatePromotionRequest $request) {
        $type = $request->type ?? PromotionType::DISCOUNT;
        if ($type === PromotionType::ACCOM_GIFT) {
            return view('admin.pages.accom-gift.create');
        }
        if ($type === PromotionType::ACCOM_PRODUCT) {
            return view('admin.pages.accom-product.create');
        }
        return view('admin.pages.promotion.product.add', compact('type'));
    }

    public function edit($id, EditPromotionRequest $request) {
        $promotion = Promotion::with(['products' => function ($q) {
            $q->select('id', 'name')->with('image', 'inventories');
        }])->findOrFail($id);
        $type = $promotion->type;
        $products = $promotion->products;
        $products->each(function ($p) {
            $p->inventories->each(function ($i) {
                $i->append('title');
            });
        });
        $productIds = $products->pluck('id')->toArray();
        if ($promotion->type === PromotionType::ACCOM_GIFT)
            return view('admin.pages.accom-gift.edit', compact('promotion', 'type', 'products', 'productIds'));
        if ($promotion->type === PromotionType::ACCOM_PRODUCT) {
            $main_product_ids = $products->where('pivot.featured', 1)->pluck('id')->toArray();
            return view('admin.pages.accom-product.edit', compact('promotion', 'type', 'products', 'productIds', 'main_product_ids'));
        }
        return view('admin.pages.promotion.product.add', compact('promotion', 'type', 'products', 'productIds'));
    }

    public function editPromotion($id, EditPromotionRequest $request) {
        $category = Category::with('products.inventories')->findOrFail($id);
        $category->products->each(function ($p) {
            $p->inventories->each(function ($i) {
                $i->append('title');
            });
        });
        $productIds = $category->products->pluck('id')->toArray();
        $products = $category->products;
        $promotion_from = $products->first()->inventories->first()->promotion_from;
        $promotion_to = $products->first()->inventories->first()->promotion_to;
        return view('admin.pages.promotion.product.add', compact('products', 'productIds', 'promotion_from', 'promotion_to'));
    }



    public function paginateProduct(Request $request) {
        $selectedIds = $request->selectedIds;
        $products = Product::with(['category', 'image', 'inventories' => function ($q) {
            return $q->with('attributes');
        }])->dontHavePromotion()->dontHaveCombo()->select('id', 'name');
        if ($selectedIds) {
            $selectedIds = implode(', ', $selectedIds);
            $products->orderByRaw("field(id, $selectedIds) desc");
        }
        return DataTables::of($products)
            ->editColumn('name', function ($product) {
                return view('admin.pages.product.components.name', compact('product'));
            })
            ->editColumn('sku', function ($product) {
                return view('admin.pages.product.components.sku', compact('product'));
            })
            ->addColumn('quantity_info', function ($product) {
                return view('admin.pages.product.components.warehouse', compact('product'));
            })
            ->addColumn('total_stock_quantity', function ($product) {
                return $product->inventories->sum('stock_quantity');
            })
            ->addColumn('price_info', function ($product) {
                return view('admin.pages.product.components.price', compact('product'));
            })
            ->addColumn('attribute_description', function ($product) {
                return view('admin.pages.product.components.attribute', compact('product'));
            })
            ->addColumn('sales', function ($product) {
                return view('admin.pages.product.components.sales', compact('product'));
            })
            ->addColumn('actions', function ($product) {
                return view('admin.pages.product.components.actions', compact('product'));
            })
            ->make(true);
    }

    public function getProductWithInventories(Request $request) {
        $ids = $request->ids ?? [];
        $products = Product::whereIn('id', $ids)->dontHavePromotion()->with('inventories', 'image')->get();
        $products->each(function ($product) {
            $product->inventories->each(function ($inventory) {
                $inventory->append('title');
            });
        });
        return BaseResponse::success($products);
    }

    public function store(CreatePromotionProductRequest $request) {
        $products = $request->products;
        $from = (new Carbon($request->from))->format('Y-m-d H:i:s');
        $to = (new Carbon($request->to))->format('Y-m-d H:i:s');
        $old_from = $request->old_from;
        $old_to = $request->old_to;
        DB::beginTransaction();
        try {
            $promotion = Promotion::create([
                'type' => $request->type ?? PromotionType::DISCOUNT,
                'name' => $request->name,
                'from' => $request->from,
                'to' => $request->to,
                'min_order_value' => $request->min_order_value,
                'status' => StatusType::ACTIVE,
                'num_of_products' => $request->num_of_products
            ]);
            $product_ids = [];
            Inventory::where('promotion_from', $old_from)->where('promotion_to', $old_to)->update([
                'promotion_from' => null,
                'promotion_to' => null,
                'promotion_price' => null
            ]);
            foreach ($products as $p) {
                foreach ($p['inventories'] as $i) {
                    $inventory = Inventory::find($i['id']);
                    $inventory->fill($i);
                    $inventory->promotion_from = $from;
                    $inventory->promotion_to = $to;
                    $inventory->save();
                }
                $product_ids[] = $p['id'];
            }
            $promotion->products()->sync($product_ids);
            if ($request->main_product_ids) {
                foreach($request->main_product_ids as $id) {
                    $promotion->products()->sync([
                        $id => [
                            'featured' => 1
                        ]
                    ], false);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return BaseResponse::success([
            'message' => 'Cập nhật danh sách sản phẩm khuyến mãi thành công'
        ]);
    }

    public function update(Promotion $promotion, UpdatePromotionRequest $request) {
        $products = $request->products;
        $from = (new Carbon($request->from))->format('Y-m-d H:i:s');
        $to = (new Carbon($request->to))->format('Y-m-d H:i:s');
        $old_from = $request->old_from;
        $old_to = $request->old_to;
        $input = [
            'from' => $from,
            'to' => $to,
            'num_of_products' => $request->num_of_products
        ];
        if ($request->min_order_value) $input['min_order_value'] = $request->min_order_value;
        DB::beginTransaction();
        try {
            $product_ids = [];
            Inventory::where('promotion_from', $old_from)->where('promotion_to', $old_to)->update([
                'promotion_from' => null,
                'promotion_to' => null,
                'promotion_price' => null
            ]);
            foreach ($products as $p) {
                foreach ($p['inventories'] as $i) {
                    $inventory = Inventory::find($i['id']);
                    $inventory->fill($i);
                    $inventory->promotion_from = $from;
                    $inventory->promotion_to = $to;
                    $inventory->save();
                }
                $product_ids[] = $p['id'];
            }
            $promotion->products()->sync($product_ids);
            if ($request->main_product_ids) {
                PromotionProduct::where('promotion_id', $promotion->id)->update([
                    'featured' => 0
                ]);
                foreach($request->main_product_ids as $id) {
                    $promotion->products()->sync([
                        $id => [
                            'featured' => 1
                        ]
                    ], false);
                }
            }
            // dd($input);
            $promotion->update($input);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
        return BaseResponse::success([
            'message' => 'Cập nhật danh sách sản phẩm khuyến mãi thành công'
        ]);
    }

    public function destroy(Promotion $promotion, DeletePromotionRequest $request) {
        $promotion->delete();
        return BaseResponse::success([
            'message' => 'Xoá chương trình thành công'
        ]);
    }
}
