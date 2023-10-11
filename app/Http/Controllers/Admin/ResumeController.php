<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ResumeController extends Controller
{
    public function index() {
        return view('admin.pages.recruitment.resume.index');
    }

    public function create() {
        return view('admin.pages.recruitment.resume.create');
    }

    public function store(Request $request) {
     Resume::create($request->all());
       return redirect()->route('admin.pages.recruitment.resume.index');
    }
    public function paginate() {
        $resumes = Resume::query()->with('jd');
        return DataTables::of($resumes)
        ->addColumn('action', function() {
            return '';
        })
        ->make(true);
    }
}
