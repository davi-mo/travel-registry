<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use App\Services\CountryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
        $cities = $cityService->getByCountry($countryId)->paginate(50);
        $country = $countryService->getById($countryId);
        return view("cities")->with("cities", $cities)->with("country", $country);
    }

    /**
     * @param string $cityId
     * @param CityService $cityService
     * @return View
     */
    public function editCityPage(string $cityId, CityService $cityService) : View
    {
        $city = $cityService->getById($cityId);
        return view("edit-city")->with("city", $city);
    }

    /**
     * @param string $cityId
     * @param Request $request
     * @param CityService $cityService
     * @return RedirectResponse
     */
    public function updateCity(
        string $cityId,
        Request $request,
        CityService $cityService
    ) : RedirectResponse {
        $city = $cityService->getById($cityId);
        $cityName = $request->get('name');
        $cityState = $request->get('state');
        $countryId = $city->country_id;

        $cityService->updateCity($city, $cityName, $cityState);
        return redirect()->to("/country/$countryId/cities");
    }
}
