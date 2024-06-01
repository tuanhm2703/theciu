<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddToCartRequest;
use App\Http\Resources\Api\CartGeneralResource;
use App\Http\Services\Cart\CartService;
use App\Models\Cart;
use App\Models\Inventory;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class CartController extends Controller {
    public function __construct(private CartService $cartService) {
    }
    public function index(Request $request) {
        $cart = $this->cartService->setUser(requestUser())->getCartWithInventories();
        return BaseResponse::success(new CartGeneralResource($cart));
    }

    public function addToCart(AddToCartRequest $request) {
        $this->cartService->setUser(requestUser())->addToCart($request);
        $cart = $this->cartService->getCartWithInventories();
        return BaseResponse::success(new CartGeneralResource($cart));
    }

    public function removeFromCart(Request $request) {
        $inventory = Inventory::find($request->inventory_id);
        $this->cartService->setUser(requestUser())->removeFromCart($inventory);
        $cart = $this->cartService->getCartWithInventories();
        return BaseResponse::success(new CartGeneralResource($cart));
    }
}
