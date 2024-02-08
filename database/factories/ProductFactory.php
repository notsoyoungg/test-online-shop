<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $img1 = 'images/pic-1.webp';
        $img2 = 'images/pic-2.webp';
        $price =  $this->faker->randomFloat(0, 10000, 100000);
        return [
            'name'         => $this->faker->unique()->word(),
            'price'        => $price,
            'discountable' => $this->faker->randomElement([null, 1]),
            'image'        => $this->faker->randomElement([$img1, $img2]),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ];
    }
}
