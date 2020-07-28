<?php

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'email' => 'existing@gmail.com',
            'password' => Hash::make('helloworld123')
        ]);
    }

    public function testMissingFields(): void
    {
        $response = $this->postJson('/api/authenticate', [
            // Nothing
        ]);

        $response->assertStatus(422);
    }

    public function testInvalidEmail(): void
    {
        $response = $this->postJson('/api/authenticate', [
            'email' => 'non_existing@gmail.com',
            'password' => 'helloworld123'
        ]);

        $response->assertStatus(401);
    }

    public function testInvalidPassword(): void
    {
        $response = $this->postJson('/api/authenticate', [
            'email' => 'existing_user@gmail.com',
            'password' => 'helloworld123_1'
        ]);

        $response->assertStatus(401);
    }

    public function testSuccessfulAuthentication()
    {
        $response = $this->postJson('/api/authenticate', [
            'email' => 'existing@gmail.com',
            'password' => 'helloworld123'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->user->delete();
    }
}
