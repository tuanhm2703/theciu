<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateEventRequest;
use App\Http\Requests\Admin\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class EventController extends Controller
{
    public function index() {
        return view('admin.pages.event.index');
    }

    public function create() {
        return view('admin.pages.event.create');
    }

    public function store(CreateEventRequest $request) {
        // return view('admin.pages.event.store');
    }


    public function edit(Event $event) {
        return view('admin.pages.event.edit', compact('event'));
    }

    public function update(UpdateEventRequest $event,  $request) {
        $event->update($request->all());
        // return redirect()->route('event.index');
    }

    public function paginate() {
        $events = Event::query();
        return DataTables::of($events)->make(true);
    }
}
