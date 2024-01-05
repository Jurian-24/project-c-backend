<?php

namespace Tests\Feature\Authentication;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user login with valid credentials.
     *
     * @return void
     */
    public function testUserLogin()
    {
        // Create a user for testing
        $user = User::factory()->create([
            'email'    => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Mock a request with valid credentials
        $response = $this->postJson('/login', [
            'email'    => 'test@example.com',
            'password' => 'password',
        ]);

        // Assert that the login was successful
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged in',
            ])
            ->assertJsonStructure([
                'token',
                'user' => [
                    'id',
                    'email',
                    'employee',
                    'basket',
                ],
            ]);

        // Additional assertions if needed based on your application logic
        // For example, you may want to check the presence of specific data in the response.
    }
}
