<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rank;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RankController extends Controller
{
    public function index() {
        return view('admin.pages.rank.index');
    }

    public function paginate() {
        $ranks = Rank::query();
        return DataTables::of($ranks)
        ->editColumn('benefit_value', function($rank) {
            return "$rank->benefit_value%";
        })
        ->editColumn('min_value', function($rank) {
            return format_currency_with_label($rank->min_value);
        })
        ->editColumn('cycle', function($rank) {
            return "$rank->cycle Tháng";
        })
        ->addColumn('action', function($rank) {
            return view('admin.pages.rank.components.action', compact('rank'));
        })->make(true);
    }

    public function create() {
        return view('admin.pages.rank.create');
    }

    public function edit(Rank $rank) {
        return view('admin.pages.rank.edit', compact('rank'));
    }

    public function update(Rank $rank, Request $request) {
        $rank->update($request->all());
        return BaseResponse::success([
            'message' => 'Rank updated successfully'
        ]);
    }

    public function store(Request $request) {
        Rank::create($request->all());
        return BaseResponse::success([
            'message' => 'Rank created successfully',
        ]);
    }
}
