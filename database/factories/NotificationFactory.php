<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'message' => $this->faker->word(),
            'status' => $this->faker->randomElement([
                'On Track',
                'Overspent',
            ]),
            'user_id' => User::factory(),
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
