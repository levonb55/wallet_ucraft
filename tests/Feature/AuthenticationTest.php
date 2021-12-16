<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /** @test */
    public function only_logged_in_users_can_see_dashboard()
    {
        $response = $this->get('/home');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_see_dashboard()
    {
        $this->actingAs(factory(User::class)->create());

        $response = $this->get('/home')->assertOk();
    }

    /** @test */
    public function register_user()
    {
        $this->post('/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $this->assertCount(1, User::all());
    }
}
