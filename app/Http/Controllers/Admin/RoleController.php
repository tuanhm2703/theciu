<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Http\Requests\Admin\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoleController extends Controller {
    public function index() {
        return view('admin.pages.module.index');
    }

    public function create() {
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $permission->name = trans("permission.$permission->name");
        }
        return view('admin.pages.module.components.create', compact('permissions'));
    }

    public function store(CreateRoleRequest $request) {
        $role = Role::create($request->all());
        $permissions = Permission::whereIn('id', $request->permission_ids)->get();
        foreach ($permissions as $permission) {
            $permission->assignRole($role);
        }
        return BaseResponse::success([
            'message' => 'Tạo quyền thành công'
        ]);
    }

    public function edit(Role $role, UpdateRoleRequest $request) {
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $permission->name = trans("permission.$permission->name");
        }
        $role->permission_ids = $role->permissions()->pluck('id')->toArray();
        return view('admin.pages.module.components.edit', compact('role', 'permissions'));
    }

    public function paginate() {
        return DataTables::of(Role::query()->where('name', '!=', 'Super Admin'))
            ->editColumn('created_at', function ($role) {
                return $role->created_at->format('d/m/Y h:i:s');
            })
            ->addColumn('action', function ($role) {
                return view('admin.pages.module.components.action', compact('role'));
            })->make(true);
    }

    public function destroy(Role $role) {
        $role->delete();
        return BaseResponse::success([
            'message' => 'Xoá quyền thành công'
        ]);
    }
}
