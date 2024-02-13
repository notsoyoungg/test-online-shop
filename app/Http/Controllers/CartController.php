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

    /**
     * Отображение корзины пользователя
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show()
    {
        $cart = auth()->user()->cart;
        if ($cart) {
            // Получаем коллекцию товаров, которые есть в корзине пользователя
            $products = Product::whereIn('id', array_keys($cart->products->toArray()))->get();
            // Получаем дополнительную информацию о корзине, такую как общую стоимоть, процент скидки и т.д.
            $cartSummary = CartService::getCartSummary(auth()->user(), $products, $cart->products);
        }

        return view('cart', [
            'cartProducts' => $cart?->products,
            'products'     => $products ?? null,
            'cartSummary'  => $cartSummary ?? null,
        ]);
    }

    /**
     * Добавление товара в корзину
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addProduct(Request $request)
    {
        $cart = Cart::whereUserId(auth()->user()->id)->first();

        // Если корзина не найдена, то создаем ее.
        $cart ??= Cart::create([
            'user_id'  => auth()->user()->id,
            'products' => [],
        ]);

        // Если в корзине уже есть товар с указанным id, то увеличиваем его количество в корзине на 1
        // если товара в коризне нет, то добавляем его в количестве 1
        if (isset($cart->products[$request->product_id])) {
            $cart->products[$request->product_id] += 1;
        } else {
            $cart->products[$request->product_id] = 1;
        }
        $cart->save();
        return redirect()->back();
    }

    /**
     * Удаление товара из корзины
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeProduct(Request $request)
    {
        $cart = Cart::whereUserId(auth()->user()->id)->first();
        if ($cart) {
            // Если в корзине есть товар с указанным id, то уменьшаем его количество на 1
            if (isset($cart->products[$request->product_id])) {
                $cart->products[$request->product_id] -= 1;
                // Если после уменьшения количество товара равняется нулю или меньше, то удаляем товар из корзины
                if ($cart->products[$request->product_id] <= 0) {
                    unset($cart->products[$request->product_id]);
                }
            }
            $cart->save();
        }
        return redirect()->back();
    }
}
