<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_dashboard_category_page_is_rendered_properly()
    {
        $this->withoutExceptionHandling();

        // create a user
        $user = User::factory()->create();

        //act as the user
        $this->actingAs($user);

        // hit to /dashboard/categories page
        $response = $this->get('/dashboard/categories');

        // assert that we got to  status 200
        $response->assertStatus(200);
    }

    public function test_the_create_category_page_is_rendered_properly()
    {
        $this->withoutExceptionHandling();

        // create a user
        $user = User::factory()->create();

        //act as the user
        $this->actingAs($user);

        // hit to /dashboard/categories/create page
        $response = $this->get('/dashboard/categories/create');

        // assert that we got to  status 200
        $response->assertStatus(200);
    }

    public function test_users_can_create_categories()
    {
        $this->withoutExceptionHandling();

        // create a user
        $user = User::factory()->create();

        //act as the user
        $this->actingAs($user);

        //hit to /dashboard/categories url with category request
        $response = $this->post('/dashboard/categories', [
            'name' => 'test1',
            'slug' => 'test1',
        ]);

        //assert we were redirected to the /dashboard/categories page
        $response->assertStatus(302);

        //got to find last category created
        $category = Category::first();

        //only have 1 category in database
        $this->assertEquals(1, Category::count());

        //assert the categories has the proper data
        $this->assertEquals('test1', $category->name);
        $this->assertEquals('test1', $category->slug);
    }

    public function test_users_can_see_the_edit_category_page()
    {
        $this->withoutExceptionHandling();

        //make a user
        $user = User::factory()->create();

        //make a category
        $category = Category::factory()->create();

        //hit to edit category page and acting as a user
        $response = $this->actingAs($user)->get('/dashboard/categories/' . $category->slug . '/edit');

        //assert 200
        $response->assertStatus(200);

        $response->assertSee($category->name);
    }

    public function test_users_can_update_category()
    {
        $this->withoutExceptionHandling();

        //make a user
        $user = User::factory()->create();

        //make a category
        $category = Category::factory()->create();

        //hit url dashboard/categories/ with put method and try to update the data
        $response = $this->actingAs($user)->put('/dashboard/categories/' . $category->slug, [
            'name'  => 'Updated Category',
            'slug' => 'Test',

        ]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/dashboard/categories');
        $this->assertEquals('Updated Category', Category::first()->name);
        $this->assertEquals('Test', Category::first()->slug);
    }

    public function test_users_can_delete_categories()
    {
        $this->withoutExceptionHandling();

        //make a user
        $user = User::factory()->create();

        //make a category
        $category =  Category::factory()->create();

        //check if category just 1
        $this->assertEquals(1, Category::count());

        //user can delete category
        $response = $this->actingAs($user)->delete('/dashboard/categories/' . $category->slug);

        $response->assertStatus(302);

        $this->assertEquals(0, Category::count());
    }
}
