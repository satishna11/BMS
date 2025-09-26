<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Database\Seeders\IncomeSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 users first
        User::factory()->count(5)->create();

        // Then seed incomes
        $this->call(IncomeSeeder::class);
    }
}
