<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateStaffRequest;
use App\Http\Requests\Admin\StoreStaffRequest;
use App\Http\Requests\Admin\UpdateStaffRequest;
use App\Http\Requests\Admin\ViewStaffRequest;
use App\Models\User;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class StaffController extends Controller {
    public function index() {
        return view('admin.pages.setting.staff.index');
    }

    public function create(CreateStaffRequest $request) {
        return view('admin.pages.setting.staff.components.create');
    }

    public function store(StoreStaffRequest $request) {
        $role_id = $request->role_id;
        $input = $request->except(['role_id']);
        $input['password'] = Hash::make('Theciu@2022');
        $user = User::create($input);
        $user->assignRole($role_id);
        return BaseResponse::success([
            'message' => 'Thêm nhân viên thành công'
        ]);
    }

    public function edit(ViewStaffRequest $request, User $staff) {
        return view('admin.pages.setting.staff.components.edit', compact('staff'));
    }

    public function update(UpdateStaffRequest $request, User $staff) {
        $staff->update($request->except('role_id'));
        $staff->syncROles($request->role_id);
        return BaseResponse::success([
            'message' => 'Cập nhật thông tin nhân viên thành công'
        ]);
    }

    public function paginate(ViewStaffRequest $request) {
        $users = User::query()->where('id', '!=', auth('web')->user()->id);
        return DataTables::of($users)
        ->addColumn('name', function($user) {
            return view('admin.pages.setting.staff.components.name', compact('user'));
        })
        ->addColumn('role', function($user) {
            return view('admin.pages.setting.staff.components.role', compact('user'));
        })
        ->editColumn('created_at', function($user) {
            return view('admin.pages.setting.staff.components.create_date', compact('user'));
        })
        ->addColumn('action', function($user) {
            return view('admin.pages.setting.staff.components.action', compact('user'));
        })
        ->make(true);
    }
}
