<?php

namespace App\Http\Controllers;

use App\Services\CountryService;
use App\Services\RegionService;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class CountryController extends Controller
{
    public function getCountriesByRegion(
        Request $request,
        CountryService $countryService,
        RegionService $regionService
    ) : View {
        $regionId = $request->get('region');
        $regions = $regionService->getActiveRegions();
        $countries = $countryService->getByRegion($regionId);
        return view("countries")
            ->with("regions", $regions)
            ->with("selectedRegionId", $regionId)
            ->with('countries', $countries);
    }
}
