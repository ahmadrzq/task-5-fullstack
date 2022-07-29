<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Authenticate user.
     *
     * @return void
     */

    //Create a user and authenticate him
    protected function authenticate()
    {
        Artisan::call('passport:install');
        $user = User::create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('secret1234'),
        ]);
        $this->user = $user;
        $token = $user->createToken('authToken')->accessToken;
        return $token;
    }

    /**
     * test create post.
     *
     * @return void
     */
    public function test_api_create_post()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', 'api/v1/posts', [
            'title' => 'Test',
            'content' => 'test',
            'excerpt' => 'test',
            'image' => 'test.png',
            'category_id' => 1,
        ]);

        $response->assertStatus(200);
    }

    /**
     * test update post.
     *
     * @return void
     */
    public function test_api_update_post()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('PUT', 'api/v1/posts/1', [
            'title' => 'Test1',
            'content' => 'test1',
            'excerpt' => 'test1',
            'image' => 'test1.png',
            'category_id' => 2,
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test find post.
     *
     * @return void
     */
    public function test_api_find_post()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', 'api/v1/posts/2');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test get all posts.
     *
     * @return void
     */
    public function test_api_get_all_post()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('GET', 'api/v1/posts');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test delete posts.
     *
     * @return void
     */
    public function test_api_delete_post()
    {
        $this->withoutExceptionHandling();

        $token = $this->authenticate();

        Post::create([
            'title' => 'Test3',
            'content' => 'test3',
            'excerpt' => 'test3',
            'image' => 'test3.png',
            'category_id' => 3,
            'user_id' => 3,
        ]);

        $post = Post::first();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('DELETE', 'api/v1/posts/1');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}
