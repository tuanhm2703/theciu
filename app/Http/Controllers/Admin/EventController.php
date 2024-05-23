<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateEventRequest;
use App\Http\Requests\Admin\UpdateEventRequest;
use App\Models\Event;
use App\Models\Product;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    public function index() {
        return view('admin.pages.event.index');
    }

    public function create() {
        return view('admin.pages.event.create');
    }

    public function store(CreateEventRequest $request) {
        $event = Event::create($request->validated());
        $event->products()->sync($request->product_ids);
        $event->createImages([$request->image]);
        return BaseResponse::success([
            'message' => 'Tạo event thành công',
            'url' => route('admin.event.index')
        ]);
    }


    public function edit(Event $event) {
        return view('admin.pages.event.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event) {
        $event->update($request->validated());
        $event->products()->sync($request->product_ids);
        if($request->image) {
            $event->image?->delete();
            $event->createImages([$request->image]);
        }
        return BaseResponse::success([
            'message' => 'Cập nhật event thành công',
            'url' => route('admin.event.index')
        ]);
    }

    public function paginate() {
        $events = Event::query();
        return DataTables::of($events)
        ->editColumn('image', function($event) {
            return view('admin.pages.event.image', compact('event'));
        })
        ->addColumn('action', function($event) {
            return view('admin.pages.event.action', compact('event'));
        })->make(true);
    }

    public function paginateProduct(Request $request) {
        $selectedIds = $request->selectedIds;
        $products = Product::with(['category', 'image', 'inventories' => function ($q) {
            return $q->with('attributes');
        }])->select('id', 'name');
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

    public function destroy(Request $request, Event $event) {
        $event->image?->delete();
        $event->delete();
        return BaseResponse::success([
           'message' => 'Xóa event thành công'
        ]);
    }
}
