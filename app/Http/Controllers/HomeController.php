<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()) {
            $cart = auth()->user()->cart;
            if ($cart)
                $cartProducts = json_decode($cart->products, true);
        }

        return view('index', [
            'products'     => Product::paginate(16),
            'cartProducts' => $cartProducts ?? null,
        ]);
    }
}
