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
        ->addColumn('candidate', function($resume) {
            return view('admin.pages.recruitment.resume.components.candidate', compact('resume'));
        })
        ->addColumn('action', function($resume) {
            return view('admin.pages.recruitment.resume.components.action', compact('resume'));
        })
        ->editColumn('created_at', function($resume) {
            return $resume->created_at->format('d/m/Y H:i:s');
        })
        ->addColumn('contact_info', function($resume) {
            return view('admin.pages.recruitment.resume.components.contact_info', compact('resume'));
        })
        ->addColumn('insign', function($resume) {
            return view('admin.pages.recruitment.resume.components.insign', compact('resume'));
        })
        ->make(true);
    }
    public function showAnswer(Resume $resume) {
        return view('admin.pages.recruitment.resume.answer', compact('resume'));
    }
    public function pdf(Resume $resume) {
        $resume->viewed = true;
        $resume->save();
        return redirect()->to($resume->pdf?->path_with_original_size);
    }
}
