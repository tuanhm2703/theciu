<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddToCartRequest;
use App\Http\Requests\Api\ChangeCartProductInventoryRequest;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Requests\Api\GetShippingInfoRequest;
use App\Http\Requests\Api\SelectCartItemRequest;
use App\Http\Requests\Api\UnselectCartItemRequest;
use App\Http\Resources\Api\CartGeneralResource;
use App\Http\Services\Cart\CartService;
use App\Models\Inventory;
use App\Responses\Api\BaseResponse;
use Illuminate\Http\Request;

class CartController extends Controller {
    public function __construct(private CartService $cartService) {
    }
    public function index(Request $request) {
        $cart = $this->cartService->setUser(requestUser())->getCartWithInventories($request->isCheckout ?? false);
        return BaseResponse::success(new CartGeneralResource($cart));
    }

    public function addToCart(AddToCartRequest $request) {
        $quantity = $request->quantity ?? 1;
        $inventory_id = $request->inventory_id;
        $this->cartService->setUser(requestUser())->addToCart($quantity, $inventory_id);
        $cart = $this->cartService->setUser(requestUser())->getCartWithInventories();
    return BaseResponse::success(new CartGeneralResource($cart));
    }

    public function removeFromCart(Request $request) {
        $inventory = Inventory::find($request->inventory_id);
        $this->cartService->setUser(requestUser())->removeFromCart($inventory);
        $cart = $this->cartService->getCartWithInventories();
        return BaseResponse::success(new CartGeneralResource($cart));
    }

    public function changeProductInventory(ChangeCartProductInventoryRequest $request) {
        $this->cartService->changeProductInventory(requestUser(), $request->old_inventory_id, $request->inventory_id);
        $cart = $this->cartService->setUser(requestUser())->getCartWithInventories();
        return BaseResponse::success(new CartGeneralResource($cart));
    }

    public function getShippingInfo(GetShippingInfoRequest $request) {
        $shipping_info = $this->cartService->getShippingInfo($request);
        return BaseResponse::success($shipping_info);
    }

    public function checkout(CheckoutRequest $request) {
        return $this->cartService->checkout($request);
    }

    public function selectItem(SelectCartItemRequest $request) {
        $this->cartService->setUser(requestUser())->selectItem($request->inventory_id);
        $cart = $this->cartService->setUser(requestUser())->getCartWithInventories();
        return BaseResponse::success(new CartGeneralResource($cart));
    }

    public function unselectItem(UnselectCartItemRequest $request) {
        $this->cartService->setUser(requestUser())->unselectItem($request->inventory_id);
        $cart = $this->cartService->setUser(requestUser())->getCartWithInventories();
        return BaseResponse::success(new CartGeneralResource($cart));
    }
}
