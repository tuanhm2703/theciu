<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;

class AttributeController extends Controller {

    public function ajaxSearch(Request $request) {
        $q = $request->q;
        $attributes = Attribute::query();
        if($q) {
            $attributes->search('name', $q);
        }
        $attributes = $attributes->select('name as text', 'id')->distinct()->paginate(8);
        return BaseResponse::success($attributes->toArray()['data']);
    }
}
