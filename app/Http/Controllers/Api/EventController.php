<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EventListResource;
use App\Http\Resources\Api\EventResource;
use App\Http\Resources\Api\ProductResource;
use App\Models\Event;
use App\Models\Product;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function paginate(Request $request) {
        $pageSize = $request->pageSize ?? 10;
        $status = $request->status;
        $events = Event::with('image');
        if($status === 'incomming') {
            $events->incomming();
        } else if($status === 'passed') {
            $events->passed();
        }
        $events = $events->orderBy('from', 'desc')->paginate($pageSize);
        $paginateData = $events->toArray();
        return BaseResponse::success([
            'items' => EventListResource::collection($events),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url']
        ]);
    }

    public function details(string $slug) {
        $event = Event::whereSlug($slug)->firstOrFail();
        return BaseResponse::success([
            'data' => new EventResource($event)
        ]);
    }

    public function getProducts(string $slug, Request $request) {
        $pageSize = $request->pageSize ?? 10;
        $event = Event::whereSlug($slug)->firstOrFail();
        $products = Product::whereHas('events', function($q) use ($event) {
            $q->where('events.id', $event->id);
        })->withNeededProductCardData()->addSalePrice()->paginate($pageSize);
        $paginateData = $products->toArray();
        return BaseResponse::success([
            'items' => ProductResource::collection($products),
            'total' => $paginateData['total'],
            'next_page' => $paginateData['next_page_url'],
            'prev_page' => $paginateData['prev_page_url'],
        ]);
    }
}
