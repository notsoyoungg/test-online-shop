<?php

namespace Database\Seeders;

use App\Models\ArrivalStock;
use App\Models\Category;
use App\Models\Company;
use App\Models\Manufac;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Schema::enableForeignKeyConstraints();
        Product::factory()->count(100)->create();
    }
}
