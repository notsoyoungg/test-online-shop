<?php

namespace App\Services;


class CartService
{
    public static function getCartSummary($user, $products, $cartProducts) {

        $cartSummary = [];
        $totalCost = 0;
        $discountableCost = 0;

        foreach ($products as $product) {
            if (isset($cartProducts[$product->id])) {
                $totalCost += $product->price * $cartProducts[$product->id];
                if ($product->discountable)
                    $discountableCost += $product->price * $cartProducts[$product->id];
            }
        }
        if ($discountableCost > 0) {
            $totalDiscount = 0;
            // значение процента скидки взял из примера предполагая, что оно одинаковое для всех товаров
            $maxDiscountPercent = 20;
            $discountPercent = min($maxDiscountPercent, ($user->bonuses / $discountableCost) * 100);
            foreach ($products as $product) {
                $result = [];
                if (isset($cartProducts[$product->id]) && $product->discountable) {
                    $itemCost = $cartProducts[$product->id] * $product->price;
                    $result['discount_percent'] = min($discountPercent, ($itemCost / $discountableCost) * 100);
                    $result['final_price'] = $itemCost - ($result['discount_percent'] / 100) * $itemCost;
                    $totalDiscount += ($result['discount_percent'] / 100) * $itemCost;
                    $cartSummary[$product->id] = $result;
                }
            }

            $cartSummary['total'] = $totalCost;
            $cartSummary['total_with_discount'] = $totalCost - $totalDiscount;
            $cartSummary['total_discount_percent'] = $totalDiscount / $totalCost * 100;
            return $cartSummary;
        }
        return null;
    }
}
