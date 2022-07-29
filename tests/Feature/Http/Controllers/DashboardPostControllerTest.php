<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DashboardPostControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_dashboard_post_page_is_rendered_properly()
    {
        $this->withoutExceptionHandling();

        // create a user
        $user = User::factory()->create();

        //act as the user
        $this->actingAs($user);

        // hit to /dashboard/posts page
        $response = $this->get('/dashboard/posts');

        // assert that we got to  status 200
        $response->assertStatus(200);
    }

    public function test_the_create_post_page_is_rendered_properly()
    {
        $this->withoutExceptionHandling();

        // create a user
        $user = User::factory()->create();

        //act as the user
        $this->actingAs($user);

        // hit to /dashboard/posts/create page
        $response = $this->get('/dashboard/posts/create');

        // assert that we got to  status 200
        $response->assertStatus(200);
    }
    
    public function test_users_can_create_posts()
    {
        $this->withoutExceptionHandling();

        // create a user
        $user = User::factory()->create();

        //act as the user
        $this->actingAs($user);

        //create a category
        $category = Category::factory()->create();

        //hit to /dashboard/posts url with post request
        $img =  UploadedFile::fake()->image('test_image.jpg');
        $response = $this->post('/dashboard/posts',[
            'title' => 'test1',
            'slug' => 'test1',
            'content' => 'lorem',
            'image' => $img,
            'category_id' => 1,
            'user_id' => 1,
        ]);

        //assert we were redirected to the /dashboard/posts page
        $response->assertStatus(302);

        //got to find last post created
        $post = Post::first();

        //only have 1 post in database
        $this->assertEquals(1,Post::count());

        //assert the posts has the proper data
        $this->assertEquals('test1', $post->title);
        $this->assertEquals('test1', $post->slug);
        $this->assertEquals('lorem', $post->content);
        $this->assertEquals($img->store('post-images'), $post->image);
        $this->assertEquals($user->id, $post->user->id);
        $this->assertInstanceOf(User::class,$post->user);
        $this->assertEquals($category->id, $post->category->id);
        $this->assertInstanceOf(Category::class,$post->category);
    }

    public function test_users_can_see_the_single_post_page()
    {
        $this->withoutExceptionHandling();

        //make a user
        $user = User::factory()->create();

        //make a post
        $post = Post::factory()->create();

        //create a category
        $category = Category::factory()->create();

        //hit to edit post page and acting as a user
        $response = $this->actingAs($user)->get('/dashboard/posts/'. $post->slug);

        //assert 200
        $response->assertStatus(200);

        $response->assertSee($post->title);
    }

    public function test_users_can_see_the_edit_post_page()
    {
        $this->withoutExceptionHandling();

        //make a user
        $user = User::factory()->create();

        //make a post
        $post = Post::factory()->create();

        //hit to edit post page and acting as a user
        $response = $this->actingAs($user)->get('/dashboard/posts/'. $post->slug. '/edit');

        //assert 200
        $response->assertStatus(200);

        $response->assertSee($post->title);
    }

    public function test_users_can_update_post()
    {
        $this->withoutExceptionHandling();

        //make a user
        $user = User::factory()->create();

        //make a category
        $category = Category::factory()->create();
        $this->assertCount(1, Category::all());
        $category = Category::first();

        //make a post
        Post::factory()->create();
        $this->assertCount(1, Post::all());
        $post = Post::first();

        //hit url dashboard/posts/ with put method and try to update the data
        $img =  UploadedFile::fake()->image('test_image_new.jpg');
        $response = $this->actingAs($user)->put('dashboard/posts/'. $post->slug, [
            'title'  => 'Updated Post',
            'slug' => 'Test',
            'content' => 'Testing',
            'image' => $img,
            'category_id' => 1

        ]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/dashboard/posts');
        $this->assertEquals('Updated Post', Post::first()->title);
        $this->assertEquals('Test', Post::first()->slug);
        $this->assertEquals('Testing', Post::first()->content);
        $this->assertEquals($img->store('post-images'), Post::first()->image);
        $this->assertEquals($category->id, Post::first()->category->id);
        $this->assertInstanceOf(Category::class, Post::first()->category);
    }

    public function test_users_can_delete_posts()
    {
        $this->withoutExceptionHandling();

        //make a user
        $user = User::factory()->create();

        //make a post
        $post =  Post::factory()->create();

        //check if post just 1
        $this->assertEquals(1, Post::count());

        //user can delete post
        $response = $this->actingAs($user)->delete('/dashboard/posts/'. $post->slug);

        $response->assertStatus(302);

        $this->assertEquals(0, Post::count());
    }


}
