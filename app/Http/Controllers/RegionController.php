<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RegionController extends Controller
{
    public function provinces(): JsonResponse
    {
        $provinces = Province::orderBy('name')->get(['id', 'name']);
        return response()->json($provinces);
    }

    public function regencies(Request $request): JsonResponse
    {
        $provinceId = $request->query('province_id');
        
        $query = Regency::orderBy('name');
        if ($provinceId) {
            $query->where('province_id', $provinceId);
        }
        
        return response()->json($query->get(['id', 'province_id', 'name']));
    }

    public function districts(Request $request): JsonResponse
    {
        $regencyId = $request->query('regency_id');
        
        $query = District::orderBy('name');
        if ($regencyId) {
            $query->where('regency_id', $regencyId);
        }
        
        return response()->json($query->get(['id', 'regency_id', 'name']));
    }

    public function villages(Request $request): JsonResponse
    {
        $districtId = $request->query('district_id');
        
        $query = Village::orderBy('name');
        if ($districtId) {
            $query->where('district_id', $districtId);
        }
        
        return response()->json($query->get(['id', 'district_id', 'name']));
    }

    private function normalize(?string $name): string
    {
        if (!$name) return '';
        $name = preg_replace('/^(PROV\.|PROP\.|KAB\.|KOTA\.|KEC\.|KEL\.|PROVINSI|KABUPATEN|KOTA|KECAMATAN|DESA|KELURAHAN)\s+/i', '', trim($name));
        $name = str_replace(['DAERAH ISTIMEWA ', 'D.I. '], 'DI ', strtoupper($name));
        $name = preg_replace('/\s+/', '', $name);
        return strtoupper(preg_replace('/[^A-Z0-9]/', '', $name));
    }

    // Advanced Name Lookups to completely offload Aksara loops!
    public function findProvince(Request $request): JsonResponse
    {
        $name = $request->query('name');
        if (!$name) return response()->json(['id' => null]);

        $normSearch = $this->normalize($name);
        $provinces = Province::all();
        foreach ($provinces as $province) {
            if ($this->normalize($province->name) === $normSearch) {
                return response()->json(['id' => $province->id]);
            }
        }

        return response()->json(['id' => null]);
    }

    public function findRegency(Request $request): JsonResponse
    {
        $name = $request->query('name');
        $provinceName = $request->query('province_name');
        if (!$name) return response()->json(['id' => null]);

        $normSearch = $this->normalize($name);
        $query = Regency::query();
        
        if ($provinceName) {
            $normProv = $this->normalize($provinceName);
            $province = Province::all()->first(fn($p) => $this->normalize($p->name) === $normProv);
            if ($province) {
                $query->where('province_id', $province->id);
            }
        }

        $regencies = $query->get();
        foreach ($regencies as $regency) {
            if ($this->normalize($regency->name) === $normSearch) {
                return response()->json(['id' => $regency->id]);
            }
        }

        return response()->json(['id' => null]);
    }

    public function findDistrict(Request $request): JsonResponse
    {
        $name = $request->query('name');
        $regencyName = $request->query('regency_name');
        if (!$name) return response()->json(['id' => null]);

        $normSearch = $this->normalize($name);
        $query = District::query();
        
        if ($regencyName) {
            $normReg = $this->normalize($regencyName);
            $regency = Regency::all()->first(fn($r) => $this->normalize($r->name) === $normReg);
            if ($regency) {
                $query->where('regency_id', $regency->id);
            }
        }

        $districts = $query->get();
        foreach ($districts as $district) {
            if ($this->normalize($district->name) === $normSearch) {
                return response()->json(['id' => $district->id]);
            }
        }

        return response()->json(['id' => null]);
    }

    public function findVillage(Request $request): JsonResponse
    {
        $name = $request->query('name');
        $districtName = $request->query('district_name');
        if (!$name) return response()->json(['id' => null]);

        $normSearch = $this->normalize($name);
        $query = Village::query();
        
        if ($districtName) {
            $normDist = $this->normalize($districtName);
            $district = District::all()->first(fn($d) => $this->normalize($d->name) === $normDist);
            if ($district) {
                $query->where('district_id', $district->id);
            }
        }

        $villages = $query->get();
        foreach ($villages as $village) {
            if ($this->normalize($village->name) === $normSearch) {
                return response()->json(['id' => $village->id]);
            }
        }

        return response()->json(['id' => null]);
    }
}
