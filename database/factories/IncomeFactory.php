<?php

namespace Database\Factories;
use App\Models\Income;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */protected $model=Income::class;

    public function definition(): array
    {
        return [
            'user_id'=>User::factory(),
            'source'=>$this->faker->word(),
            'amount'=>$this->faker->randomFloat(2,100,5000),
            'date'=>$this->faker->dateTimeBetween('-1 year','now'),
        ];
    }
}
