<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    

    public function test_api_register()  
    {
        $this->withoutExceptionHandling();

        Artisan::call('passport:install');

        $response = $this->json('POST', '/api/v1/register', [
            'name'  =>  $name = 'Test',
            'email'  =>  $email = time().'test@example.com',
            'password'  =>  $password = '123456789',
        ]);

        $response->assertStatus(200);

        // Receive our token
        $this->assertArrayHasKey('access_token',$response->json());

    }

    public function test_api_login()
    {
        $this->withoutExceptionHandling();
        // Creating Users
        User::create([
            'name' => 'Test',
            'email'=> $email = time().'@example.com',
            'password' => $password = bcrypt('123456789')
        ]);

        // Simulated landing
        $response = $this->json('POST','/api/v1/login',[
            'email' => $email,
            'password' => $password,
        ]);

        // Determine whether the login is successful and receive token 
        $response->assertStatus(200);

        //$this->assertArrayHasKey('token',$response->json());

        // Delete users
        User::where('email','test@gmail.com')->delete();
    }
}