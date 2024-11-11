<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Database\Seeders\AccountSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\SubcategorySeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardControllerTest extends TestCase
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

    public function test_cards_return_correct_data()
    {
        $response = $this->getJson('/api/v1/cards');
        $response->assertStatus(200);
        $response->assertJson([
            "code" => 200,
            "success" => true,
            "messages" => "Success",
            "data" => [
                "total_categories" => 5,
                "total_subcategories" => 10,
                "total_accounts" => 17,
                "total_journals" => 0
            ]
        ]);
    }
}
