<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Combo;
use App\Models\Inventory;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ComboController extends Controller {
    public function index() {
        return view('admin.pages.combo.index');
    }

    public function create() {
        return view('admin.pages.combo.create');
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $combo = new Combo();
            $combo->fill($request->except('products'));
            $combo->status = StatusType::ACTIVE;
            $combo->save();
            foreach ($request->products as $product) {
                $combo->products()->attach($product['id']);
                foreach ($product['inventories'] as $i) {
                    $inventory = Inventory::find($i['id']);
                    $inventory->update($i);
                }
            }
            DB::commit();
            return BaseResponse::success([
                'message' => 'Tạo combo thành công'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function edit($id) {
        $combo = Combo::with(['products' => function ($q) {
            $q->select('products.id', 'name')->with('image', 'inventories');
        }])->findOrFail($id);
        $products = $combo->products;
        $products->each(function ($p) {
            $p->inventories->each(function ($i) {
                $i->append('title');
            });
        });
        $productIds = $products->pluck('id')->toArray();
        return view('admin.pages.combo.edit', compact('combo', 'products', 'productIds'));
    }
    public function update(Combo $combo, Request $request) {
        $combo->fill($request->except('products'));
        $combo->status = StatusType::ACTIVE;
        $combo->save();
        $product_ids = collect($request->products)->unique('id')->pluck('id')->toArray();
        $combo->products()->sync($product_ids);
        foreach ($request->products as $product) {
            foreach ($product['inventories'] as $i) {
                $inventory = Inventory::find($i['id']);
                $inventory->update($i);
            }
        }
        return BaseResponse::success([
            'message' => 'Cật nhật combo thành công'
        ]);
    }
    public function paginate() {
        $combos = Combo::query()->with('products.image');
        return DataTables::of($combos)
            ->addColumn('product_img_list', function ($combo) {
                return view('admin.pages.combo.components.product_img_list', compact('combo'));
            })
            ->addColumn('combo_status_label', function ($combo) {
                return view('admin.pages.combo.components.combo-status-label', compact('combo'));
            })
            ->addColumn('time', function ($combo) {
                return view('admin.pages.combo.components.time', compact('combo'));
            })
            ->addColumn('action', function ($combo) {
                return view('admin.pages.combo.components.action', compact('combo'));
            })
            ->make(true);
    }

    public function updateStatus(Combo $combo, Request $request) {
        $status = $request->status;
        $combo->status = $status;
        $combo->save();
        if ($combo->status == StatusType::INACTIVE) {
            Inventory::whereIn('id', $combo->products()->pluck('id')->toArray())->update([
                'promotion_to' => now()->yesterday(),
                'promotion_from' => now()->yesterday()
            ]);
        } else {
            Inventory::whereIn('id', $combo->products()->pluck('id')->toArray())->update([
                'promotion_from' => $combo->from,
                'promotion_to' => $combo->to,
            ]);
        }
        return BaseResponse::success([
            'message' => 'Cập nhật trạng thái chương trình thành công!'
        ]);
    }

    public function viewProductListModal() {
        return view('admin.pages.combo.modal.product');
    }
}
