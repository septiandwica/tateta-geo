<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class IndonesiaRegionsSeeder extends Seeder
{
    private function getBpsData(string $level, string $parent): array
    {
        $url = 'https://sig.bps.go.id/rest-drop-down/getwilayah';
        
        try {
            $response = Http::timeout(20)->retry(3, 1000)->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept' => 'application/json, text/plain, */*',
                'Accept-Language' => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                'Referer' => 'https://sig.bps.go.id/',
                'Origin' => 'https://sig.bps.go.id',
            ])->get($url, [
                'level' => $level,
                'parent' => $parent,
                'periode_merge' => '2025_1.2025'
            ]);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            $this->command->error("Failed to fetch $level for parent $parent: " . $e->getMessage());
        }

        return [];
    }

    public function run(): void
    {
        $this->command->info('=== STARTING BPS ADMINISTRATIVE REGIONS CRAWLER ===');

        // Step 1: Provinces
        $this->command->info('Checking Provinces...');
        if (Province::count() === 0) {
            $this->command->info('Crawling Provinces from BPS...');
            // As per BPS API, parent for provinsi is the period key: '2025_1.2025'
            $provinces = $this->getBpsData('provinsi', '2025_1.2025');
            
            if (empty($provinces)) {
                $this->command->error('No provinces fetched from BPS! Please verify your internet connection.');
                return;
            }

            $provincesData = [];
            foreach ($provinces as $prov) {
                if (isset($prov['kode']) && isset($prov['nama'])) {
                    $provincesData[] = [
                        'id' => trim((string)$prov['kode']),
                        'name' => strtoupper(trim($prov['nama'])),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            Province::insertOrIgnore($provincesData);
            $this->command->info('Provinces saved successfully: ' . count($provincesData));
        } else {
            $this->command->info('Provinces already seeded (Count: ' . Province::count() . '). Skipping.');
        }

        // Step 2: Regencies
        $this->command->info('Checking Regencies...');
        if (Regency::count() === 0) {
            $this->command->info('Crawling Regencies from BPS...');
            $provinces = Province::all();
            foreach ($provinces as $prov) {
                $this->command->info("Crawling Regencies for Province: {$prov->name} ({$prov->id})...");
                $regencies = $this->getBpsData('kabupaten', $prov->id);
                
                $regenciesData = [];
                foreach ($regencies as $reg) {
                    if (isset($reg['kode']) && isset($reg['nama'])) {
                        $regenciesData[] = [
                            'id' => trim((string)$reg['kode']),
                            'province_id' => $prov->id,
                            'name' => strtoupper(trim($reg['nama'])),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                if (!empty($regenciesData)) {
                    foreach (array_chunk($regenciesData, 100) as $chunk) {
                        Regency::insertOrIgnore($chunk);
                    }
                    $this->command->info("  -> Saved " . count($regenciesData) . " regencies.");
                }
                usleep(100000); // 100ms polite delay
            }
        } else {
            $this->command->info('Regencies already seeded (Count: ' . Regency::count() . '). Skipping.');
        }

        // Step 3: Districts
        $this->command->info('Checking Districts...');
        if (District::count() === 0) {
            $this->command->info('Crawling Districts from BPS...');
            $allRegencies = Regency::all();
            foreach ($allRegencies as $regency) {
                $this->command->info("Crawling Districts for Regency: {$regency->name} ({$regency->id})...");
                $districts = $this->getBpsData('kecamatan', $regency->id);
                
                $districtsData = [];
                foreach ($districts as $dist) {
                    if (isset($dist['kode']) && isset($dist['nama'])) {
                        $districtsData[] = [
                            'id' => trim((string)$dist['kode']),
                            'regency_id' => $regency->id,
                            'name' => strtoupper(trim($dist['nama'])),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
                if (!empty($districtsData)) {
                    foreach (array_chunk($districtsData, 100) as $chunk) {
                        District::insertOrIgnore($chunk);
                    }
                    $this->command->info("  -> Saved " . count($districtsData) . " districts.");
                }
                usleep(100000); // 100ms polite delay
            }
        } else {
            $this->command->info('Districts already seeded (Count: ' . District::count() . '). Skipping.');
        }

        // Step 4: Villages (Highly Resumable & Safe)
        $this->command->info('Checking Villages...');
        
        // Find districts that do not have any seeded villages yet
        $districtsToCrawl = District::whereDoesntHave('villages')->get();
        $totalDistrictsToCrawl = $districtsToCrawl->count();

        if ($totalDistrictsToCrawl > 0) {
            $this->command->info("Crawling Villages from BPS for {$totalDistrictsToCrawl} remaining districts...");
            
            $counter = 0;
            foreach ($districtsToCrawl as $district) {
                $counter++;
                $this->command->info("[{$counter}/{$totalDistrictsToCrawl}] Crawling Villages for District: {$district->name} ({$district->id})...");
                
                $villages = $this->getBpsData('desa', $district->id);
                
                $villagesData = [];
                foreach ($villages as $vil) {
                    if (isset($vil['kode']) && isset($vil['nama'])) {
                        $villagesData[] = [
                            'id' => trim((string)$vil['kode']),
                            'district_id' => $district->id,
                            'name' => strtoupper(trim($vil['nama'])),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

                if (!empty($villagesData)) {
                    // No global database transaction! We insert and commit per district immediately.
                    // This prevents long-lived transactions, locking issues, and respects database consistency.
                    foreach (array_chunk($villagesData, 100) as $chunk) {
                        Village::insertOrIgnore($chunk);
                    }
                    $this->command->info("  -> Saved " . count($villagesData) . " villages.");
                } else {
                    $this->command->warn("  -> No villages returned for district: {$district->name} ({$district->id})");
                }
                
                // Keep it light and polite to avoid BPS blocking
                usleep(50000); // 50ms polite delay
            }
        } else {
            $this->command->info('All villages are already seeded successfully! (Count: ' . Village::count() . '). Skipping.');
        }

        $this->command->info('=== BPS ADMINISTRATIVE REGIONS CRAWLER COMPLETED SUCCESSFULLY! 🎉 ===');
    }
}
