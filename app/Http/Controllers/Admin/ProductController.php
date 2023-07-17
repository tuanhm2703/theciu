<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MediaType;
use App\Events\ProductCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\DeleteProductRequest;
use App\Http\Requests\Admin\EditProductRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Requests\Admin\ViewProductRequest;
use App\Models\Attribute;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Product;
use App\Responses\Admin\BaseResponse;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller {
    public function store(StoreProductRequest $request) {
        $attributes = json_decode($request->input('attributes'));
        $input = $request->all();
        $input['description'] = $request->input('short_description');
        DB::beginTransaction();
        try {
            $product = new Product($input);
            $product->save();
            if ($request->hasFile('images')) {
                $product->createImages($request->images);
            }
            if ($request->hasFile('video')) {
                $product->createImages([$request->file('video')], MediaType::VIDEO, 'videos');
            }
            if ($request->hasFile('size-rule-img')) {
                $product->createImages($request->file('size-rule-img'), MediaType::SIZE_RULE);
            }
            $product->categories()->attach($request->input('category_id'));
            foreach ($attributes[0]->values as $index => $value) {
                foreach ($value->inventories as $inventory) {
                    $inventory->sku = trim($inventory->sku);
                    $newInventory = $product->inventories()->create((array) $inventory);
                    $order = 0;
                    foreach ($inventory->attributes as $attribute) {
                        $order++;
                        $newAttribute = Attribute::firstOrCreate([
                            'id' => $attribute->id,
                            'name' => $attribute->name
                        ]);
                        $newInventory->attributes()->attach($newAttribute->id, ['value' => $attribute->value, 'order' => $order]);
                        if ($request->hasFile("attribute-image-$index")) {
                            $file = $request->file("attribute-image-$index");
                            $newInventory->createImages([$file]);
                        }
                    }
                }
            }
            DB::commit();
            return BaseResponse::success([
                'message' => "Tạo sản phẩm thành công"
            ]);
        } catch (\Throwable $th) {
            \Log::error($th);
            DB::rollBack();
            return BaseResponse::error([
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function update(UpdateProductRequest $request, Product $product) {
        $attributes = json_decode($request->input('attributes'));
        $input = $request->all();
        $input['description'] = $request->input('short_description');
        $deleteImages = json_decode($request->input('deleteImages'));
        DB::beginTransaction();
        try {
            $product->fill($input);
            $product->save();
            if ($request->hasFile('images')) {
                $product->createImages($request->images);
            }
            if ($request->hasFile('video')) {
                $product->createImages([$request->file('video')], MediaType::VIDEO, 'videos');
            }
            if ($request->hasFile('size-rule-img')) {
                $product->createImages($request->file('size-rule-img'), MediaType::SIZE_RULE);
            }
            $product->categories()->detach(optional($product->category)->id);
            $product->categories()->attach($request->input('category_id'));
            $inventory_ids = [];
            $inventory_image = null;
            foreach ($attributes[0]->values as $index => $value) {
                foreach ($value->inventories as $inventory) {
                    $inventory->sku = trim($inventory->sku);
                    $newInventory = $product->inventories()->updateOrCreate([
                        'id' => $inventory->id
                    ], (array) $inventory);
                    $inventory_ids[] = $newInventory->id;
                    $newInventory->attributes()->detach();
                    $order = 0;
                    foreach ($inventory->attributes as $attribute) {
                        $order++;
                        $newAttribute = Attribute::firstOrCreate([
                            'id' => $attribute->id,
                            'name' => $attribute->name
                        ]);
                        $newInventory->attributes()->attach([$newAttribute->id], ['value' => $attribute->value, 'order' => $order]);
                        if ($request->hasFile("attribute-image-$index")) {
                            $inventory_image = $request->file("attribute-image-$index");
                        }
                        if($inventory_image) {
                            $newInventory->createImages([$inventory_image]);
                        }
                    }
                }
            }
            $product->inventories()->whereNotIn('inventories.id', $inventory_ids)->delete();
            foreach ($deleteImages as $index => $path) {
                $deleteImages[$index] = str_replace(StorageService::url(''), '', $path);
            }
            Image::whereIn('path', $deleteImages)->delete();
            DB::commit();
            return BaseResponse::success([
                'message' => "Cập nhật sản phẩm thành công"
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error($th);
            return BaseResponse::error([
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function index(ViewProductRequest $request) {
        return view('admin.pages.product.index');
    }
    public function create(CreateProductRequest $request) {
        return view('admin.pages.product.create');
    }

    public function destroy(DeleteProductRequest $request, Product $product) {
        $product->delete();
        return BaseResponse::success([
            'message' => 'Xoá sản phẩm thành công'
        ]);
    }

    public function edit(EditProductRequest $request, Product $product) {
        $category = $product->category;
        if($category) {
            $category_ids = [$category->id];
            while ($category->category && $category->category->id !== $category->id) {
                $category = $category->category;
                array_unshift($category_ids, $category->id);
            }
        } else {
            $category_ids = [];
        }
        $product['category_ids'] = $category_ids;
        $listImgSources = $product->images->pluck('path_with_original_size')->toArray();
        $productSizeRuleSrc = $product->size_rule_images->pluck('path_with_original_size')->toArray();
        return view('admin.pages.product.edit', compact('product', 'listImgSources', 'productSizeRuleSrc'));
    }

    public function massDelete(Request $request) {
        $productIds = $request->product_ids;
        Product::whereIn('id', $productIds)->delete();
        return BaseResponse::success([
            'message' => 'Sản phẩm đã được xoá thành công'
        ]);
    }
}
