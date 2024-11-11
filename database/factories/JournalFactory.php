<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Journal>
 */
class JournalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_code' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'date' => Carbon::now()->format('Y-m-d'),
            'description' => $this->faker->word(25),
        ];
    }
}
