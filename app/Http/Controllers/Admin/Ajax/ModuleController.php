<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Role;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ModuleController extends Controller {
    public function paginateRoles() {
        return BaseResponse::success(DataTables::of(Role::query())->make(true));
    }
}
