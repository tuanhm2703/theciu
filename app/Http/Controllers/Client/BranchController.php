<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function ajaxGetBranches() {
        $branches = Branch::active()->with('image', 'address')->get();
        return BaseResponse::success($branches);
    }
}
