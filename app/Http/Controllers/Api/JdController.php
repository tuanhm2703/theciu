<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostResumeRequest;
use App\Models\Jd;
use App\Models\Resume;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class JdController extends Controller
{
    public function index(Request $request) {
        $pageSize = $request->pageSize ?? 15;
        $jds = Jd::orderBy('created_at', 'desc');
        if($request->group) {
            $jds->whereGroup($request->group);
        }
        if($request->keyword) {
            $jds->search('name', $request->keyword);
        }
        $jds = $jds->paginate($pageSize);
        return BaseResponse::success($jds);
    }

    public function postResume(PostResumeRequest $request, Jd $jd) {
        $resume = $jd->resumes()->create($request->all());
        if($request->hasFile('file')) {
            $resume->createImages([$request->file('file')], 'pdf');
        }
        return BaseResponse::success([
            'data' => null,
            'message' => 'Bạn đã ứng tuyển thành công!'
        ]);
    }
}
