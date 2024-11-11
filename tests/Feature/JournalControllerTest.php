<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AccountSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\SubcategorySeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class JournalControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:refresh');

        $data = [UserSeeder::class, CategorySeeder::class, SubcategorySeeder::class, AccountSeeder::class];
        $this->seed($data);

        Sanctum::actingAs(User::first());
    }

    public function test_get_journals()
    {
        $response = $this->getJson('/api/v1/journals?search=abc');
        $response->assertStatus(200);
    }

    // public function test_post_journals_total_debit_credit_not_equal() {}

    // public function test_post_journals_debit_balance_not_enough() {}

    // public function test_post_journals_debit_balance_bigger_than_zero() {}

    // public function test_post_journals_debit_balance_smaller_than_zero() {}

    // public function test_post_journals_not_debit_over_payment() {}

    // public function test_post_journals_not_debit_credit_bigger_than_zero() {}

    // public function test_post_journals_not_debit_credit_smaller_than_zero() {}
}
