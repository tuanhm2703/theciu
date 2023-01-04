<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ModuleController extends Controller {
    public function getPermissions(Module $module) {
        $permissions = $module->permissions();
        return BaseResponse::success(DataTables::of($permissions)->make(true));
    }
}
