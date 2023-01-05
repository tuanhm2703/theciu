<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Client\CartResource;
use App\Models\Cart;
use App\Models\Inventory;
use App\Responses\Admin\BaseResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller {
    public function index() {
        return view('landingpage.layouts.pages.cart.index');
    }

    public function addToCart(Request $request) {
        $id = $request->inventoryId;
        $inventory = Inventory::findOrFail($id);
        $customer = auth('customer')->user();
        $cart = Cart::firstOrCreate([
            'customer_id' => $customer->id
        ]);
        if ($cart->inventories()->where('inventories.id', $inventory->id)->exists()) {
            $cart->inventories()->sync([$inventory->id => ['quantity' => DB::raw("cart_items.quantity + 1")]], false);
        } else {
            $cart->inventories()->sync([$inventory->id => ['quantity' => 1, 'customer_id' => $customer->id]], false);
        }
        return BaseResponse::success([
            'message' => "Thêm sản phẩm vào giỏ hàng thành công",
            'data' => new CartResource($cart),
            'view' => view('landingpage.layouts.components.navs.cart')->render()
        ]);
    }

    public function removeFromCart(Request $request) {
        $inventoryId = $request->inventoryId;
        $customer = auth('customer')->user();
        $cart = Cart::firstOrCreate([
            'customer_id' => $customer->id
        ]);
        $cart->inventories()->detach([$inventoryId]);
        return BaseResponse::success([
            'message' => "Xoá sản phẩm khỏi giỏ hàng thành công",
            'data' => new CartResource($cart),
            'view' => view('landingpage.layouts.components.navs.cart')->render()
        ]);
    }
}
