<?php

namespace Database\Factories;

use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subcategory_id' => Subcategory::factory()->create(),
            'name' => $this->faker->name(),
            'code' => $this->faker->word(5),
            'initial_balance' => $this->faker->numberBetween(0, 1000000),
            'initial_balance_date' => Carbon::now()->format('Y-m-d'),
            'balance' => $this->faker->numberBetween(0, 1000000),
        ];
    }
}
