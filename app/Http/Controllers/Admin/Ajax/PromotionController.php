<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Enums\PromotionType;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Promotion;
use App\Models\Voucher;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PromotionController extends Controller {
    public function viewListProduct() {
        return view('admin.pages.promotion.modal.product');
    }

    public function paginate(Request $request) {
        $type = $request->type ?? PromotionType::DISCOUNT;
        $promotions = Promotion::query()->whereType($type)->with('products', function ($q) {
            $q->with('image')->whereHas('inventories')->with('inventories')->select('products.name', 'products.id');
        });
        return DataTables::of($promotions)
            ->editColumn('name', function ($promotion) {
                return view('admin.pages.promotion.components.name', compact('promotion'));
            })
            ->addColumn('promotiom_status_label', function ($promotion) {
                return view('components.admin.promotion-status-label', compact('promotion'));
            })
            ->addColumn('product_img_list', function ($promotion) {
                return view('admin.pages.promotion.components.product_img_list', compact('promotion'));
            })
            ->editColumn('min_order_value', function($promotion) {
                return format_currency_with_label($promotion->min_order_value);
            })
            ->addColumn('time', function ($promotion) {
                return view('admin.pages.promotion.components.time', compact('promotion'));
            })
            ->addColumn('action', function ($promotion) {
                return view('admin.pages.promotion.components.action', compact('promotion'));
            })
            ->make(true);
    }

    public function updateStatus(Promotion $promotion, Request $request) {
        $status = $request->status;
        $promotion->status = $status;
        $promotion->save();
        if($promotion->status == StatusType::INACTIVE) {
            Inventory::whereIn('id', $promotion->products()->pluck('id')->toArray())->update([
                'promotion_to' => now()->yesterday(),
                'promotion_from' => now()->yesterday()
            ]);
        } else {
            Inventory::whereIn('id', $promotion->products()->pluck('id')->toArray())->update([
                'promotion_from' => $promotion->from,
                'promotion_to' => $promotion->to,
            ]);
        }
        return BaseResponse::success([
            'message' => 'Cập nhật trạng thái chương trình thành công!'
        ]);
    }

    public function updateVoucherStatus(Request $request, Voucher $voucher) {
        $voucher->status = $request->status;
        $voucher->save();
        return BaseResponse::success([
            'message' => 'Cập nhật trạng thái voucher thành công!'
        ]);
    }
    public function getBatchSaleInventories(Request $request) {

    }
}
