<?php

namespace Tests\Feature\API;

use App\Models\APIKey;
use App\Models\Space;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FetchTransactionsTest extends TestCase
{
    private $user;
    private $space;
    private $expiredAPIKey;
    private $existingAPIKey;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->space = factory(Space::class)->create();

        $this->user->spaces()->sync([$this->space->id]);

        $this->expiredAPIKey = factory(APIKey::class)->create([
            'user_id' => $this->user->id,
            'token' => 'expired'
        ]);

        $this->existingAPIKey = factory(APIKey::class)->create([
            'user_id' => $this->user->id,
            'token' => 'existing'
        ]);
    }

    public function testMissingAPIKey(): void
    {
        $response = $this->get('/api/transactions', [
            // Nothing
        ]);

        $response->assertStatus(403);
    }

    public function testInvalidAPIKey(): void
    {
        $response = $this->get('/api/transactions', [
            'Authorization' => 123
        ]);

        $response->assertStatus(403);
    }

    public function testExpiredAPIKey(): void
    {
        $response = $this->get('/api/transactions', [
            'Authorization' => 'non_existing'
        ]);

        $response->assertStatus(403);
    }

    public function testSuccessfulRequest(): void
    {
        $response = $this->get('/api/transactions', [
            'Authorization' => 'existing'
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([]); // Empty because there shouldn't be any transactions
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->expiredAPIKey->delete();
        $this->existingAPIKey->delete();

        // $this->user->spaces()->sync([]); // Clear relationship, preventing foreign keys from acting up

        // $this->space->delete();
        // $this->user->delete();

        /**
         * Cannot delete space and user currently, since other tests depend on
         * these entities. I know, this is isn't how things are supposed to work,
         * but this shall be fixed in the future.
         */
    }
}
