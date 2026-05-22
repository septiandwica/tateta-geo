<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Province;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed at least one province for testing
        Province::create([
            'id' => '11',
            'name' => 'ACEH',
        ]);
    }

    public function test_api_requires_authentication()
    {
        $response = $this->getJson('/api/v1/geo/provinces');

        $response->assertStatus(401);
    }

    public function test_api_allows_access_with_valid_token()
    {
        $user = User::factory()->create();
        
        // Generate a Sanctum token
        $token = $user->createToken('test-device')->plainTextToken;

        // Perform request with the token in Authorization header
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/geo/provinces');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'ACEH']);
    }

    public function test_api_denies_access_after_token_revocation()
    {
        $user = User::factory()->create();
        
        // Generate a token
        $tokenInstance = $user->createToken('test-device');
        $token = $tokenInstance->plainTextToken;

        // Revoke the token immediately (before making the request)
        $tokenInstance->accessToken->delete();

        // Verify it does not work
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/geo/provinces');
        
        $response->assertStatus(401);
    }

    public function test_health_check_endpoint_is_public()
    {
        $response = $this->getJson('/api/health');

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'healthy',
            'database' => 'connected',
        ]);
    }
}
