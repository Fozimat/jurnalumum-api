<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use App\Models\Subcategory;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(User::factory()->create());
    }

    public function test_get_accounts_dont_have_paginate()
    {
        $response = $this->getJson('/api/v1/accounts?search=abc');
        $response->assertStatus(200);
    }

    public function test_get_accounts_have_paginate()
    {
        $response = $this->getJson('/api/v1/accounts?paginate=10');
        $response->assertStatus(200);
    }

    public function test_get_detail_subcategories_success()
    {
        $subcategories = Subcategory::factory()->create();
        $response = $this->getJson('/api/v1/accounts/subcategory/' . $subcategories->id);
        $response->assertStatus(200);
    }

    public function test_get_detail_subcategories_fail()
    {
        $subcategories = Subcategory::factory()->create();
        $response = $this->getJson('/api/v1/accounts/subcategory/' . $subcategories->id + 1);
        $response->assertStatus(404);
    }

    public function test_get_detail_accounts_success()
    {
        $account = Account::factory()->create();
        $response = $this->getJson('/api/v1/accounts/' . $account->id);
        $response->assertStatus(200);
    }

    public function test_get_detail_accounts_fail()
    {
        $account = Account::factory()->create();
        $response = $this->getJson('/api/v1/accounts/' . $account->id + 1);
        $response->assertStatus(404);
    }

    public function test_post_accounts_success()
    {
        $accounts = Account::factory()->make()->toArray();
        $response = $this->postJson('/api/v1/accounts', $accounts);
        $response->assertStatus(201);
    }

    public function test_post_accounts_fail()
    {
        $accounts = Account::factory()->make(['name' => ''])->toArray();
        $response = $this->postJson('/api/v1/accounts', $accounts);
        $response->assertStatus(422);
    }

    public function test_update_accounts_success()
    {
        $accounts = Account::factory()->create();
        $response = $this->putJson('/api/v1/accounts/' . $accounts->id, $accounts->toArray());
        $response->assertStatus(201);
    }

    public function test_update_accounts_fail()
    {
        $accounts = Account::factory()->create();
        $new_accounts = Account::factory()->make(['name' => ''])->toArray();
        $response = $this->putJson('/api/v1/accounts/' . $accounts->id, $new_accounts);
        $response->assertStatus(422);
    }

    public function test_update_accounts_not_found()
    {
        $accounts = Account::factory()->create();
        $response = $this->putJson('/api/v1/accounts/' . $accounts->id + 1, $accounts->toArray());
        $response->assertStatus(404);
    }

    public function test_delete_accounts_success()
    {
        $account = Account::factory()->create();
        $response = $this->deleteJson('/api/v1/accounts/' . $account->id);
        $response->assertStatus(200);
    }

    public function test_delete_accounts_fail()
    {
        $account = Account::factory()->create();
        $response = $this->deleteJson('/api/v1/accounts/' . $account->id + 1);
        $response->assertStatus(404);
    }
}
