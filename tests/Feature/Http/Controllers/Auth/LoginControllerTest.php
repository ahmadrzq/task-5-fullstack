<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered()
    {
        $this->withoutExceptionHandling();

        //hit to /login page
        $response = $this->get('/login');

        //assert that we get to status 200
        $response->assertStatus(200);
    }

    public function test_anyone_can_login()
    {
        $this->withoutExceptionHandling();

        // create a user
        $user = User::factory()->create();

        //hit to /login page with post method
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        //redirect to home after login
        $response->assertRedirect('/');
    }

    public function test_user_loggedin_can_be_logout()
    {
        $this->withoutExceptionHandling();

        // create a user
        $user = User::factory()->create();

        //acting as a user
        $this->actingAs($user);

        //hit to /login page with post method
        $response = $this->post('/logout');

        //redirect to home after logout
        $response->assertRedirect('/');
    }

}
