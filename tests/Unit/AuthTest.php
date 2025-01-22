<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can log in with valid credentials.
     */
    public function testUserCanLoginWithValidCredentials()
    {
        // Arrange: Create a user with valid credentials
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);
    
        // Act: Attempt to log in
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);
    
        // Assert: Check if the user is authenticated and redirected to the correct URL
        $response->assertRedirect('/dashboard');  // Change this to /dashboard if that's the correct path
        $this->assertAuthenticatedAs($user);
    }
    

    /**
     * Test that a user cannot log in with invalid credentials.
     */
    public function test_user_cannot_login_with_invalid_credentials()
    {
        // Arrange: Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Act: Attempt to log in with wrong password
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        // Assert: Check if the user is not authenticated
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test that a logged-in user can log out.
     */
    public function test_user_can_logout()
    {
        // Arrange: Create and log in a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        // Act: Attempt to log out
        $response = $this->post('/logout');

        // Assert: Check if the user is logged out and redirected
        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
