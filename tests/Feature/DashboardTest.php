<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_can_be_rendered_if_authenticated()
    {
        $this->withoutExceptionHandling();

        //create a user 
        $user = User::factory()->create();

        //acting as a user
        $this->actingAs($user);

        //go to dashboard page
        $response = $this->get('/dashboard');

        //assert 200
        $response->assertStatus(200);
    }

    public function test_dashboard_can_not_be_rendered_if_not_authenticated_and_redirect_to_login_page()
    {
        //go to dashboard page
        $response = $this->get('/dashboard');

        //go to login page if not authenticated
        $response->assertRedirect('/login');

    }
}
