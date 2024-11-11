<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Journal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DetailJournalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'journal_id' => Journal::factory()->create(),
            'account_id' => Account::factory()->create(),
            'debit' => 0,
            'credit' => 100000,
        ];
    }
}
