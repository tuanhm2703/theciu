<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BranchResource;
use App\Models\Branch;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function all() {
        $branches = Branch::active()->with('image', 'address')->get();
        $branches->each(function($branch) {
            $branch->open_time = carbon($branch->open_time)->format('H:i');
            $branch->close_time = carbon($branch->close_time)->format('H:i');
        });
        return BaseResponse::success(BranchResource::collection($branches));
    }
}
