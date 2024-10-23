<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserAuthenticationTest extends TestCase {
    use RefreshDatabase;

    public function test_user_can_register() {
        // Arrange
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role'  =>  'user'
        ];

        // Act
        $response = $this->postJson('/api/register', $data);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_can_login() {
        // Arrange
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password')
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => 'password'
        ];

        // Act
        $response = $this->postJson('/api/login', $data);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['token', 'name', 'role']]);
    }

    public function test_user_cannot_login_with_invalid_credentials() {
        // Act
        $response = $this->postJson('/api/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalidpassword'
        ]);

        // Assert
        $response->assertStatus(422);
    }
}
