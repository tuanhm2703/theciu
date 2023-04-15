<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index() {
        return view('admin.pages.customer.index');
    }

    public function paginate() {
        $customers = Customer::withCount(['orders' => function($q) {
            $q->where('orders.order_status', OrderStatus::DELIVERED);
        }])->leftJoin('orders', 'customers.id', '=', 'orders.id')->addSelect(DB::raw('sum(orders.total) as total_revenue'))->groupBy('customers.id');
        return DataTables::of($customers)
        ->editColumn('total_revenue', function($customer) {
            return view('admin.pages.customer.components.revenue', compact('customer'));
        })
        ->make(true);
    }
}
