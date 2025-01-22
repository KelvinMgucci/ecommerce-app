<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RegistTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if the registration page is accessible.
     *
     * @return void
     */
    public function testRegistrationPageIsAccessible()
    {
        // Visit the registration page and check if the response is OK (200)
        $response = $this->get('/register');  // Adjust this URL based on your route
        $response->assertStatus(200);
    }

    /**
     * Test successful registration.
     *
     * @return void
     */
    public function testUserCanRegisterSuccessfully()
    {
        // Arrange: Define user registration details
        $userData = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123', // Ensure this is hashed when storing
            'password_confirmation' => 'password123', // Password confirmation
        ];

        // Act: Submit the registration form
        $response = $this->post('/register', $userData);

        // Assert: Check if the user is redirected to the dashboard (or another page)
        $response->assertRedirect('/dashboard');  // Adjust based on your redirect logic

        // Assert: Check if the user was successfully created in the database
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
        ]);

        // Assert: Check if the user is authenticated
        $this->assertAuthenticatedAs(User::where('email', 'testuser@example.com')->first());
    }

    /**
     * Test registration with invalid data.
     *
     * @return void
     */
    public function test_user_cannot_register_with_invalid_data()
    {
        // Step 1: Define invalid data
        $userData = [
            'name' => 'Test User',
            'email' => 'invalid-email', // Invalid email
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
    
        // Step 2: Submit registration form with invalid data
        $response = $this->post('/register', $userData);
    
        // Step 3: Assert the response status code is 302 (redirect back)
        $response->assertStatus(302);
    
        // Step 4: Assert the registration form is redirected with errors
        $response->assertSessionHasErrors(['email']); // Check for the 'email' validation error
    }
    
}
