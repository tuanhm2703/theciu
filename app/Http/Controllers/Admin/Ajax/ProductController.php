<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Imports\ProductBatchImport;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Responses\Admin\BaseResponse;
use App\Services\BatchService;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    private BatchService $batchService;
    public function __construct(BatchService $batchService)
    {
        $this->batchService = $batchService;
    }
    public function paginate(Request $request)
    {
        $products = Product::with(['category', 'image:path,imageable_id', 'images:path,imageable_id', 'inventories' => function ($q) {
            return $q->with('attributes');
        }])->select('products.id', 'products.name', 'products.sku', 'products.updated_at');
        if ($request->ids) $products->whereIn('id', $request->ids);
        if($request->selected) {
            $products->orderByField('id', $request->selected, 'desc');
        }
        return DataTables::of($products)
            ->editColumn('name', function ($product) {
                return view('admin.pages.product.components.name', compact('product'));
            })
            ->addColumn('inventory_sku', function ($product) {
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
            ->addColumn('sale_price', function ($product) {
                return view('admin.pages.product.components.sale_price', compact('product'));
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
            ->addColumn('image_list', function ($product) {
                return view('admin.pages.product.components.image_list', compact('product'));
            })
            ->make(true);
    }

    public function getInventories(Product $product)
    {
        $attribute_ids = $product->inventory->attributes()->orderBy('attribute_inventory.created_at', 'desc')->pluck('attributes.id')->toArray();
        $attribute_ids = implode(',', $attribute_ids);
        $attributes = Attribute::with(['inventories' => function ($q) use ($product) {
            $q->where('product_id', $product->id)->select('inventories.*')->addSelect('attribute_inventory.value')->with('attributes:id,name,attribute_inventory.value', 'image');
        }])->whereHas('inventories', function ($q) use ($product) {
            $q->where('product_id', $product->id);
        })->orderBy(DB::raw("field(attributes.id, $attribute_ids)"))->get();
        foreach ($attributes as $attribute) {
            $values = [];
            foreach ($attribute->inventories as $inventory) {
                $index = array_search($inventory->value, array_column($values, 'value'));
                if ($index > -1) {
                    $values[$index]['inventories'][] = $inventory;
                } else {
                    $values[] = [
                        'value' => $inventory->value,
                        'inventories' => [$inventory],
                        'image' => optional($inventory->image)->path_with_domain
                    ];
                }
            }
            $attribute['values'] = $values;
        }
        return BaseResponse::success($attributes);
    }

    public function ajaxSearchDetailsInfoAttribute(Request $request)
    {
        $q = $request->q;
        $field = $request->field ?? 'model';
        $values = Product::select("$field as text")->search($field, $q)->paginate(8)->toArray()['data'];
        foreach ($values as $index => $value) {
            $values[$index]['id'] = $value['text'];
        }
        return BaseResponse::success($values);
    }

    public function loadBatchCreateView()
    {
        return view('admin.pages.product.modal-view.batch-create');
    }

    public function loadBatchUpdateView()
    {
        return view('admin.pages.product.modal-view.batch-update');
    }

    public function createFromFile(Request $request)
    {
        $import = new ProductBatchImport;
        $path = $request->file('batch-create-file')->store('temp');
        $collection = $import->toCollection($path);
        $data = $collection[0];
        return $data;
        $fields = $data[1];
        return $collection;
        unset($data[0]);
        unset($data[1]);
        $records = $data;
        foreach ($records as $record) {
            $object = [];
            $attributes = new Collection();
            foreach ($record as $index => $value) {
                $object[$fields[$index]] = $value;
            }
            $product = Product::where('code', $object['code'])->first() ?? new Product();
            $product->fill($object);
            $product->save();
            $category = Category::firstOrCreate([
                'name' => $object['category'],
                'status' => 1
            ], ['order' => 0]);
            $product->categories()->attach($category->id);
            $attributes->push(Attribute::firstOrCreate([
                'name' => $object['attribute_name_1']
            ]));
            $attribute_values = explode(',', $object['attribute_values_1']);
            $inventories = new Collection();
            $attribute_image_urls = explode(',', $object['image_attribute_1']);
            foreach ($attribute_values as $index => $value) {
                if ($object['attribute_name_2']) {
                    $attributes->push(Attribute::firstOrCreate([
                        'name' => $object['attribute_name_2']
                    ]));
                    $attribute_values_2 = explode(',', $object['attribute_values_2']);
                    foreach ($attribute_values_2 as $value2) {
                        $inventory = new Inventory();
                        $inventory->price = $object['price'];
                        $inventory->product_id = $product->id;
                        $inventory->stock_quantity = $object['stock_quantity'];
                        $inventory->sku = $object['inventory_sku'];
                        $inventory->save();
                        $inventories->push($inventory);
                        $inventory->attributes()->attach([
                            $attributes->first()->id => ['value' => $value],
                            $attributes->last()->id => ['value' => $value2]
                        ]);
                        $inventory->createImagesFromUrls([$attribute_image_urls[$index]]);
                    }
                } else {
                    $inventory = new Inventory();
                    $inventory->price = $object['price'];
                    $inventory->product_id = $product->id;
                    $inventory->stock_quantity = $object['stock_quantity'];
                    $inventory->sku = $object['inventory_sku'];
                    $inventory->save();
                    $inventories->push($inventory);
                    $inventory->attributes()->attach([
                        $attributes->first()->id => ['value' => $value]
                    ]);
                    $inventory->createFromUrls([$attribute_image_urls[$index]]);
                }
            }
        }
        return BaseResponse::success([
            'records' => $inventories,
            'message' => 'Tạo thành công'
        ]);
    }

    public function batchUpdateFromFile(Request $request)
    {
        return BaseResponse::success([
            'message' => 'Cập nhật thành công',
            'product_ids' => $this->batchService->updateBatch($request->file('file'))
        ]);
    }

    public function downloadBatchUpdateFile(Request $request)
    {
        $type  = $request->type;
        return $this->batchService->getBatchUpdateFile($type);
    }
}
