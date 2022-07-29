<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_can_be_rendered()
    {
        $this->withoutExceptionHandling();

        //hit to /register page
        $response = $this->get('/register');

        //assert that we get to status 200
        $response->assertStatus(200);
    }

    public function test_anyone_can_register()
    {
        $this->withoutExceptionHandling();

        //hit to /register page
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        //asssert authenticated
        $this->assertAuthenticated();

        //assert redirect ro homepage after register
        $response->assertRedirect('/');
    }
}
