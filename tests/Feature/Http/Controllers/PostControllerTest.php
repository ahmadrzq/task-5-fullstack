<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_can_be_rendered_if_not_authenticated()
    {
        $this->withoutExceptionHandling();

        //hit to /register page
        $response = $this->get('/');

        //assert that we get to status 200
        $response->assertStatus(200);
    }

    public function test_home_page_can_be_rendered_if_authenticated()
    {
        $this->withoutExceptionHandling();

        //make a user
        $user = User::factory()->create();

        //hit to /register page
        $response = $this->actingAs($user)->get('/');

        //assert that we get to status 200
        $response->assertStatus(200);
    }

    public function test_can_see_single_post_if_authenticated()
    {
        $this->withoutExceptionHandling();

        //make a user
        $user = User::factory()->create();

        //make a post
        $post = Post::factory()->create();

        //create a category
        $category = Category::factory()->create();

        //hit to /register page
        $response = $this->actingAs($user)->get('/homeposts/'. $post->slug);

        //assert that we get to status 200
        $response->assertStatus(200);
    }

    public function test_can_see_single_post_if_not_authenticated()
    {
        $this->withoutExceptionHandling();

        //make a post
        $post = Post::factory()->create();

        //create a category
        $category = Category::factory()->create();

        //hit to /register page
        $response = $this->get('/homeposts/'. $post->slug);

        //assert that we get to status 200
        $response->assertStatus(200);
    }

    

    



}
