<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CustomerWishlistResource;
use App\Models\Event;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class EventController extends Controller {
    public function mark(string $slug, Request $request) {
        $user = requestUser();
        $event = Event::whereSlug($slug)->firstOrFail();
        if (!$user->query_wishlist(Event::class)->where('wishlistable_id', $event->id)->exists()) {
            $event->addToWishlist($user->id);
        }
        return BaseResponse::success(new CustomerWishlistResource($user));
    }

    public function removeMark(string $slug, Request $request) {
        $user = requestUser();
        $event = Event::whereSlug($slug)->firstOrFail();
        $event->removeFromCustomerWishlist($user->id);
        return BaseResponse::success(new CustomerWishlistResource($user));
    }
}
