<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateJdRequest;
use App\Http\Requests\Admin\UpdateJdRequest;
use App\Models\Jd;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class JDController extends Controller {
    public function index() {
        return view('admin.pages.recruitment.jd.index');
    }

    public function paginate() {
        $jds = JD::query()->withCount('resumes');
        return DataTables::of($jds)
            ->addColumn('action', function ($jd) {
                return view('admin.pages.recruitment.jd.components.action', compact('jd'));
            })
            ->editColumn('created_at', function($jd) {
                return $jd->created_at->format('d/m/Y H:i:s');
            })
            ->make(true);
    }

    public function create() {
        $job_types = Jd::pluck('job_type', 'job_type')->toArray();
        $groups = Jd::pluck('group', 'group')->toArray();
        return view('admin.pages.recruitment.jd.create', compact('job_types', 'groups'));
    }

public function store(CreateJdRequest $request) {
        $input = $request->validated();
        $input['featured'] = $request->featured == 'on';
        $jd = Jd::create($input);
        session()->flash('success', 'Tạo JD thành công');
        return view('admin.pages.recruitment.jd.index');
    }

    public function edit(Jd $jd) {
        $job_types = Jd::pluck('job_type', 'job_type')->toArray();
        $groups = Jd::pluck('group', 'group')->toArray();
        return view('admin.pages.recruitment.jd.edit', compact('job_types', 'groups', 'jd'));
    }

    public function update(Jd $jd, UpdateJdRequest $request) {
        $input = $request->validated();
        $input['featured'] = $request->featured == 'on';
        $jd->update($input);
        session()->flash('success', 'Cập nhật thành công');
        return view('admin.pages.recruitment.jd.index');
    }

    public function destroy(Jd $jd) {
        $jd->delete();
        return view('admin.pages.recruitment.jd.index');
    }
    public function viewResumeTable() {
        return view('admin.pages.recruitment.resume.components.modal');
    }
}
