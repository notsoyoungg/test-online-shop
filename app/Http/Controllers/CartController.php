<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show()
    {
        $cart = auth()->user()->cart;
        if ($cart) {
            $cartProducts = json_decode($cart->products, true);
            $products = Product::whereIn('id', array_keys($cartProducts))->get();
            $cartSummary = CartService::getCartSummary(auth()->user(), $products, $cartProducts);
        }

        return view('cart', [
            'cartProducts' => $cartProducts ?? null,
            'products'     => $products ?? null,
            'cartSummary'  => $cartSummary ?? null,
        ]);
    }

    public function addProduct(Request $request)
    {
        $cart = Cart::whereUserId(auth()->user()->id)->first();
        if (!$cart)
            $cart = Cart::create([
                'user_id'  => auth()->user()->id,
                'products' => json_encode([]),
             ]);

        if ($cart) {
            $productsArray = json_decode($cart->products, true);
            if (isset($productsArray[$request->product_id]))
                $productsArray[$request->product_id] += 1;
            else
                $productsArray[$request->product_id] = 1;

            $cart->products = json_encode($productsArray);
            $cart->save();
        }
        return redirect()->back();
    }

    public function removeProduct(Request $request)
    {
        $cart = Cart::whereUserId(auth()->user()->id)->first();
        if ($cart) {
            $productsArray = json_decode($cart->products, true);
            if (isset($productsArray[$request->product_id])) {
                $productsArray[$request->product_id] -= 1;
                if ($productsArray[$request->product_id] <= 0)
                    unset($productsArray[$request->product_id]);
            }
            $cart->products = json_encode($productsArray);
            $cart->save();
        }
        return redirect()->back();
    }
}
