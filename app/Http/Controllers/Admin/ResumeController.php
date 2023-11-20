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
        ->addColumn('action', function($resume) {
            return view('admin.pages.recruitment.resume.components.action', compact('resume'));
        })
        ->editColumn('created_at', function($resume) {
            return $resume->created_at->format('d/m/Y H:i:s');
        })
        ->make(true);
    }

    public function pdf(Resume $resume) {
        return redirect()->to($resume->pdf?->path_with_domain);
    }
}
