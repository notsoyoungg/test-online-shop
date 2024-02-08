<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        User::factory()->count(10)->create();
    }
}
