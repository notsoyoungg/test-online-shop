<?php

namespace App\Services;


class CartService
{
    /**
     * @param $user
     * @param $products
     * @param $cartProducts
     * @return array
     */
    public static function getCartSummary($user, $products, $cartProducts): array {

        $cartSummary = [];
        $totalCost = 0;
        $discountableCost = 0;

        // totalCost - подсчитваем стоимость всех товаров в корзине
        // discountableCost - подсчитваем стоимость товаров, к которым можно применить скидку
        foreach ($products as $product) {
            if (isset($cartProducts[$product->id])) {
                $totalCost += $product->price * $cartProducts[$product->id];
                // Если товар подлежит скидке, то прибовляем его стоимоть умноженную на количество к discountableCost
                if ($product->discountable) {
                    $discountableCost += $product->price * $cartProducts[$product->id];
                }
            }
        }

        $cartSummary['total'] = $totalCost;

        // Если у пользователя есть бонусы и в корзине есть товары, к которым может быть применена скидка, то расчитываем её
        if ($discountableCost > 0 && $user->bonuses > 0) {
            $totalDiscount = 0;
            // значение процента скидки взял из примера предполагая, что оно одинаковое для всех товаров
            $maxDiscountPercent = 20;
            // расчитываем максимальный процент скидки, который будет применен
            $discountPercent = min($maxDiscountPercent, ($user->bonuses / $discountableCost) * 100);
            foreach ($products as $product) {
                $result = [];
                if (isset($cartProducts[$product->id]) && $product->discountable) {
                    $result['discount_percent'] = min($discountPercent, ($product->price / $discountableCost) * 100);
                    // цена товара после применения скидки
                    $result['final_price'] = $product->price - ($result['discount_percent'] / 100) * $product->price;
                    $totalDiscount += ($result['discount_percent'] / 100) * $product->price;
                    $cartSummary[$product->id] = $result;
                }
            }

            // общая стоимость товаров с учетом скидки
            $cartSummary['total_with_discount'] = $totalCost - $totalDiscount;
            // процент скидки от общей стоимости товаров в корзине
            $cartSummary['total_discount_percent'] = $totalDiscount / $totalCost * 100;
        }
        return $cartSummary;
    }
}
