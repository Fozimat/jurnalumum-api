<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SubcategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(User::factory()->create());
    }

    public function test_get_subcategories()
    {
        $response = $this->getJson('/api/v1/subcategories?search=abc');
        $response->assertStatus(200);
    }

    public function test_get_detail_subcategories_success()
    {
        $category = Category::factory()->create();
        $subcategory = Subcategory::factory()->create(['category_id' => $category->id]);
        $response = $this->getJson('/api/v1/subcategories/' . $subcategory->id);
        $response->assertStatus(200);
    }

    public function test_get_detail_subcategories_fail()
    {
        $category = Category::factory()->create();
        $subcategory = Subcategory::factory()->make(['category_id' => $category->id]);
        $response = $this->getJson('/api/v1/subcategories/' . $subcategory->id + 100);
        $response->assertStatus(404);
    }

    public function test_post_subcategories_success()
    {
        $category = Category::factory()->create();
        $subcategory = Subcategory::factory()->make(['category_id' => $category->id]);
        $response = $this->postJson('/api/v1/subcategories', $subcategory->toArray());
        $response->assertStatus(201);
    }

    public function test_post_subcategories_fail()
    {
        $category = Category::factory()->create();
        $subcategory = Subcategory::factory()->make(['category_id' => $category->id + 1]);
        $response = $this->postJson('/api/v1/subcategories', $subcategory->toArray());
        $response->assertStatus(422);
    }

    public function test_update_subcategories_success()
    {
        $category = Category::factory()->create();
        $subcategory = Subcategory::factory()->create(['category_id' => $category->id]);
        $new_subcategory = Subcategory::factory()->make(['category_id' => $category->id]);
        $response = $this->putJson('/api/v1/subcategories/' . $subcategory->id, $new_subcategory->toArray());
        $response->assertStatus(200);
    }

    public function test_update_subcategories_fail()
    {
        $category = Category::factory()->create();
        $subcategory = Subcategory::factory()->create(['category_id' => $category->id]);
        $new_subcategory = Subcategory::factory()->make(['category_id' => $category->id + 1]);
        $response = $this->putJson('/api/v1/subcategories/' . $subcategory->id, $new_subcategory->toArray());
        $response->assertStatus(422);
    }

    public function test_update_subcategories_not_found()
    {
        $subcategory = Subcategory::factory()->create();
        $response = $this->putJson('/api/v1/subcategories/' . $subcategory->id + 1, $subcategory->toArray());
        $response->assertStatus(404);
    }

    public function test_delete_subcategories_success()
    {
        $category = Category::factory()->create();
        $subcategory = Subcategory::factory()->create(['category_id' => $category->id]);
        $response = $this->deleteJson('/api/v1/subcategories/' . $subcategory->id);
        $response->assertStatus(200);
    }

    public function test_delete_subcategories_not_found()
    {
        $category = Category::factory()->create();
        $subcategory = Subcategory::factory()->create(['category_id' => $category->id]);
        $response = $this->deleteJson('/api/v1/subcategories/' . $subcategory->id + 1);
        $response->assertStatus(404);
    }
}
