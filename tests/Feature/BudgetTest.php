\<?php

use App\Models\Budget;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory as Faker;

uses(RefreshDatabase::class);

it('saves budgets in database', function () {
    $faker = Faker::create();

    $user     = User::factory()->create();
    $category = Category::factory()->create();

    $budget = Budget::create([
        'user_id'        => $user->id,
        'category_id'    => $category->category_id,
        'year'           => $faker->year(),
        'month'          => $faker->monthName(),
        'planned_budget' => 2000,
        'spent_budget'   => 1000,
        'remaining'      => 1000,
        'status'         => 'On Track',
    ]);

    $this->assertDatabaseHas('budgets', [
        'budget_id'      => $budget->budget_id,
        'user_id'        => $user->id,
        'category_id'    => $category->category_id,
        'planned_budget' => 2000,
        'spent_budget'   => 1000,
        'remaining'      => 1000,
        'status'         => 'On Track',
    ]);
});
