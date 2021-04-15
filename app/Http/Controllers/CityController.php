<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use App\Services\CountryService;
use Illuminate\Contracts\View\View;

class CityController extends Controller
{
    /**
     * @param string $countryId
     * @param CityService $cityService
     */
    public function getCitiesByCountry(
        string $countryId,
        CityService $cityService,
        CountryService $countryService
    ) : View {
        $cities = $cityService->getByCountry($countryId)->simplePaginate(50);
        $country = $countryService->getById($countryId);
        return view("cities")->with("cities", $cities)->with("country", $country);
    }
}
