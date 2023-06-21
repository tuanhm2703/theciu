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
        $branches->each(function($branch) {
            $branch->open_time = carbon($branch->open_time)->format('H:i');
            $branch->close_time = carbon($branch->close_time)->format('H:i');
        });
        return BaseResponse::success($branches);
    }
}
