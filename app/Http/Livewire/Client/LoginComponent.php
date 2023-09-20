<?php

namespace App\Http\Livewire\Client;

use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LoginComponent extends Component
{
    public $username;

    public $password;
    public $remember = false;
    public $currentRoute;
    protected $rules = [
        'username' => 'required|username_exists',
        'password' => 'required|correct_password',
    ];

    public function render()
    {
        return view('livewire.client.login-component');
    }

    public function login() {
        $this->validate([
            'username' => 'required|username_exists',
            'password' => 'required|correct_password:customers,'.$this->username,
        ]);
        $customer = Customer::findByUserName($this->username);
        $intendedUrl = session()->get('url.intended');
        auth('customer')->login($customer, $this->remember);
        $this->syncSessionCart();
        if($intendedUrl) {
            return redirect()->intended();
        }
        $this->dispatchBrowserEvent('refreshPage');
    }
    private function syncSessionCart() {
        try {
            $customer = customer();
        if (session()->has('cart')) {
            $cart = unserialize(session()->get('cart'));
            foreach ($cart->inventories as $inventory) {
                $customer->cart = Cart::with(['inventories' => function ($q) {
                    return $q->with('image:path,imageable_id', 'product:id,slug,name');
                }])->firstOrCreate([
                    'customer_id' => auth('customer')->user()->id
                ]);
                if ($customer->cart->inventories()->where('inventories.id', $inventory->id)->exists()) {
                    $customer->cart->inventories()->sync([$inventory->id => ['quantity' => $inventory->order_item->quantity ? $inventory->order_item->quantity : DB::raw("cart_items.quantity + 1")]], false);
                } else {
                    $customer->cart->inventories()->sync([$inventory->id => ['quantity' => $inventory->order_item->quantity ? $inventory->order_item->quantity : 1, 'customer_id' => $customer->id]], false);
                }
            }
            session()->forget('cart');
        }
        } catch (\Throwable $th) {
            \Log::error($th);
        }
    }
}
