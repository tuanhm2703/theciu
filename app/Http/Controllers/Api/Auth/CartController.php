<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddToCartRequest;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Requests\Api\GetShippingInfoRequest;
use App\Http\Resources\Api\CartGeneralResource;
use App\Http\Services\Cart\CartService;
use App\Http\Services\Shipping\Models\DeliveryData;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Product;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class CartController extends Controller {
    public function __construct(private CartService $cartService) {
    }
    public function index() {
        $cart = $this->cartService->setUser(requestUser())->getCartWithInventories();
        return BaseResponse::success(new CartGeneralResource($cart));
    }

    public function addToCart(AddToCartRequest $request) {
        $quantity = $request->quantity ?? 1;
        $inventory_id = $request->inventory_id;
        $this->cartService->setUser(requestUser())->addToCart($quantity, $inventory_id);
        $cart = $this->cartService->getCartWithInventories();
        return BaseResponse::success(new CartGeneralResource($cart));
    }

    public function removeFromCart(Request $request) {
        $inventory = Inventory::find($request->inventory_id);
        $this->cartService->setUser(requestUser())->removeFromCart($inventory);
        $cart = $this->cartService->getCartWithInventories();
        return BaseResponse::success(new CartGeneralResource($cart));
    }

    public function getShippingInfo(GetShippingInfoRequest $request) {
        $shipping_info = $this->cartService->getShippingInfo($request);
        return BaseResponse::success($shipping_info);
    }

    public function checkout(CheckoutRequest $request) {

    }
}
