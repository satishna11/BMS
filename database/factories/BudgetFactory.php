<?php

namespace Database\Factories;
use App\Models\Budget;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Budget>
 */
class BudgetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */protected $model=Budget::class;
    public function definition(): array
    {
        return [
             'user_id'     => User::factory(),
            'category_id' => Category::factory(),
            'planned_budget'=>2000,
            'spent_budget'=>1000,
            'remaining'=>1000,
            'year'=>2025,
            'month'=>'January',
            'status'=>'On Track',

        ];
    }
}
