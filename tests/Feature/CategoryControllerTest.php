<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(User::factory()->create());
        // Sanctum::actingAs(User::first());
    }

    public function test_get_categories()
    {
        $response = $this->getJson('/api/v1/categories?search=abc');
        $response->assertStatus(200);
    }

    public function test_get_detail_categories_success()
    {
        $category = Category::factory()->create();
        $response = $this->getJson('/api/v1/categories/' . $category->id);
        $response->assertStatus(200);
    }

    public function test_get_detail_categories_fail()
    {
        $category = Category::factory()->create();
        $response = $this->getJson('/api/v1/categories/' . $category->id + 1);
        $response->assertStatus(404);
    }

    public function test_post_categories_success()
    {
        $category = Category::factory()->make();
        $response = $this->postJson('/api/v1/categories', $category->toArray());
        $response->assertStatus(201);
    }

    public function test_post_categories_fail()
    {
        $category = Category::factory()->make(['name' => '']);
        $response = $this->postJson('/api/v1/categories', $category->toArray());
        $response->assertStatus(422);
    }

    public function test_update_categories_success()
    {
        $category = Category::factory()->create();
        $new_category = Category::factory()->make();
        $response = $this->putJson('/api/v1/categories/' . $category->id, $new_category->toArray());
        $response->assertStatus(200);
    }

    public function test_update_categories_fail()
    {
        $category = Category::factory()->create();
        $new_category = Category::factory()->make(['name' => '']);
        $response = $this->putJson('/api/v1/categories/' . $category->id, $new_category->toArray());
        $response->assertStatus(422);
    }

    public function test_update_categories_not_found()
    {
        $category = Category::factory()->create();
        $new_category = Category::factory()->make();
        $response = $this->putJson('/api/v1/categories/' . $category->id + 1, $new_category->toArray());
        $response->assertStatus(404);
    }

    public function test_delete_categories_success()
    {
        $category = Category::factory()->create();
        $response = $this->deleteJson('/api/v1/categories/' . $category->id);
        $response->assertStatus(200);
    }

    public function test_delete_categories_not_found()
    {
        $category = Category::factory()->create();
        $response = $this->deleteJson('/api/v1/categories/' . $category->id + 1);
        $response->assertStatus(404);
    }
}
