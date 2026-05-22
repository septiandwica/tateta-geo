<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;

        // Seed mock database hierarchy
        $province = Province::create(['id' => '11', 'name' => 'ACEH']);
        $regency = Regency::create(['id' => '1101', 'province_id' => '11', 'name' => 'KABUPATEN ACEH SELATAN']);
        $district = District::create(['id' => '1101010', 'regency_id' => '1101', 'name' => 'BAKONGAN']);
        Village::create(['id' => '1101010001', 'district_id' => '1101010', 'name' => 'KEUDE BAKONGAN']);
    }

    public function test_can_fetch_provinces()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/api/v1/geo/provinces');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'ACEH']);
    }

    public function test_can_fetch_regencies_with_optional_filter()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/api/v1/geo/regencies?province_id=11');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'KABUPATEN ACEH SELATAN']);

        // Empty filter returns all
        $responseAll = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/api/v1/geo/regencies');
        $responseAll->assertStatus(200);
    }

    public function test_can_fetch_districts_with_optional_filter()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/api/v1/geo/districts?regency_id=1101');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'BAKONGAN']);
    }

    public function test_can_fetch_villages_with_optional_filter()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/api/v1/geo/villages?district_id=1101010');

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'KEUDE BAKONGAN']);
    }

    public function test_can_find_province_by_name()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/api/v1/geo/provinces/find?name=aceh');

        $response->assertStatus(200);
        $response->assertJson(['id' => '11']);
    }

    public function test_can_find_regency_by_name()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/api/v1/geo/regencies/find?name=KABUPATEN ACEH SELATAN&province_name=aceh');

        $response->assertStatus(200);
        $response->assertJson(['id' => '1101']);
    }

    public function test_can_find_district_by_name()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/api/v1/geo/districts/find?name=BAKONGAN&regency_name=KABUPATEN ACEH SELATAN');

        $response->assertStatus(200);
        $response->assertJson(['id' => '1101010']);
    }

    public function test_can_find_village_by_name()
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $this->token])
            ->getJson('/api/v1/geo/villages/find?name=KEUDE BAKONGAN&district_name=BAKONGAN');

        $response->assertStatus(200);
        $response->assertJson(['id' => '1101010001']);
    }
}
