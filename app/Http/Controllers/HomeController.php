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
        // Если есть аутентифицированный пользователь, то пытаемся получить данные о товарах в корзине.
        if (auth()->user()) {
            $cartProducts = auth()->user()->cart?->products;
        }

        return view('index', [
            'products'     => Product::paginate(16),
            'cartProducts' => $cartProducts ?? null,
        ]);
    }
}
