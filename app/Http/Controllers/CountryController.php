<?php

namespace App\Http\Controllers;

use App\Services\CountryService;
use App\Services\RegionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class CountryController extends Controller
{
    /**
     * @param Request $request
     * @param CountryService $countryService
     * @param RegionService $regionService
     * @return View
     */
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

    /**
     * @param string $countryId
     * @param CountryService $countryService
     * @return View
     */
    public function editCountryPage(string $countryId, CountryService $countryService) : View
    {
        $country = $countryService->getById($countryId);
        return view("edit-country")->with("country", $country);
    }

    /**
     * @param string $countryId
     * @param Request $request
     * @param CountryService $countryService
     * @param RegionService $regionService
     * @return RedirectResponse
     */
    public function updateCountry(
        string $countryId,
        Request $request,
        CountryService $countryService,
        RegionService $regionService
    ) : RedirectResponse {
        $country = $countryService->getById($countryId);
        $region = $regionService->getRegion($request->get('region'));
        $countryName = $request->get('name');
        $countryCode = $request->get('code');
        $countryCapital = $request->get('capital');

        $countryService->updateCountry($country, $region, $countryName, $countryCode, $countryCapital);
        return redirect()->to('/regions/active');
    }
}
