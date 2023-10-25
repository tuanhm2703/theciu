<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostResumeRequest;
use App\Models\Jd;
use App\Models\Resume;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class JdController extends Controller {
    public function index(Request $request) {
        $pageSize = $request->pageSize ?? 15;
        $jds = Jd::select('from_date', 'to_date', 'short_description', 'status', 'job_type', 'group', 'name', 'slug', 'id', 'created_at', 'featured')->withCount('wishlists')->active()->orderBy('created_at', 'desc');
        if ($request->group) {
            $jds->whereGroup($request->group);
        }
        if ($request->keyword) {
            $jds->search('name', $request->keyword);
        }
        if ($request->has('featured')) {
            $jds->where('featured', $request->featured);
        }
        $jds = $jds->paginate($pageSize);
        return BaseResponse::success($jds);
    }

    public function detail($slug) {
        $jd = Jd::whereSlug($slug)->firstOrFail();
        return BaseResponse::success([
            'data' => $jd
        ]);
    }

    public function postResume(PostResumeRequest $request, $slug) {
        $jd = Jd::whereSlug($slug)->firstOrFail();
        $resume = $jd->resumes()->create($request->all());
        if ($request->hasFile('file')) {
            $resume->createImages([$request->file('file')], 'pdf');
        }
        return BaseResponse::success([
            'data' => null,
            'message' => 'Bạn đã ứng tuyển thành công!'
        ]);
    }

    public function relatedJobs($slug, Request $request) {
        $limit = $request->limit ?? 3;
        $job = Jd::whereSlug($slug)->firstOrFail();
        $jobs = Jd::active()->where('id', '!=', $job->id)->where('group', $job->group)->whereJobType($job->job_type)
                ->union(Jd::active()->where('id', '!=', $job->id)->whereGroup($job->group)
                ->union(Jd::active()->where('id', '!=', $job->id)->whereJobType($job->job_type)))->orderBy('to_date', 'desc')->limit($limit)->get();
        return BaseResponse::success($jobs);
    }
}
