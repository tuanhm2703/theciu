<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BranchController extends Controller {
    public function index() {
        return view('admin.pages.branch.index');
    }

    public function create() {
        return view('admin.pages.branch.create');
    }

    public function edit(Branch $branch) {
        $branch->with('image');
        $branch['province_id'] = $branch->address?->province_id;
        $branch['district_id'] = $branch->address?->district_id;
        $branch['ward_id'] = $branch->address?->ward_id;
        return view('admin.pages.branch.edit', compact('branch'));
    }

    public function store(Request $request) {
        $branch = Branch::create($request->all());
        $branch->addresses()->create([
            'ward_id' => $request->ward_id,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'details' => $request->address['details']
        ]);
        $branch->createImages([$request->file('image')]);
        return BaseResponse::success([
            'message' => 'Tạo chi nhánh thành công',
            'url' => route('admin.branch.index')
        ]);
    }

    public function update(Branch $branch, Request $request) {
        $branch->update($request->all());
        $branch->address->update([
            'ward_id' => $request->ward_id,
            'province_id' => $request->province_id,
            'district_id' => $request->district_id,
            'details' => $request->address['details']
        ]);
        $branch->createImages([$request->file('image')]);
        return BaseResponse::success([
            'message' => 'Cập nhật thông tin chi nhánh thành công',
            'url' => route('admin.branch.edit', $branch->id)
        ]);
    }

    public function destroy(Branch $branch) {
        $branch->delete();
        return BaseResponse::success([
            'message' => 'Cập nhật thông tin chi nhánh thành công'
        ]);
    }

    public function paginate() {
        $branches = Branch::query()->with('address');
        return DataTables::of($branches)
            ->editColumn('name', function ($branch) {
                return view('admin.pages.branch.components.name', compact('branch'));
            })
            ->addColumn('action', function ($branch) {
                return view('admin.pages.branch.components.action', compact('branch'));
            })
            ->make(true);
    }
}
