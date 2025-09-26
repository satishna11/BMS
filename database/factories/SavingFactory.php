<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Saving;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Saving>
 */
class SavingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */protected $model=Saving::class;
    public function definition(): array
    {
        return [
            'goal'=>$this->faker->word(),
            'target_amount'=>$this->faker->randomFloat(2,100,2000),
            'amount'=>$this->faker->randomFloat(2,100,5000),
            'user_id'=>User::factory(),
        ];
    }
}
