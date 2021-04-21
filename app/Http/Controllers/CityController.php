<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use App\Services\CountryService;
use App\Services\RegionService;
use App\Services\VisitedCitiesService;
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
        Request $request,
        CityService $cityService,
        CountryService $countryService
    ) : View {
        $name = $request->get('name');
        $cities = $name ?
            $cityService->filterCity($countryId, $name)->paginate(50) :
            $cityService->getByCountry($countryId)->paginate(50);

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
     * @param CityService $cityService
     * @return View
     */
    public function markVisitedCity(string $cityId, CityService $cityService) : View
    {
        $city = $cityService->getById($cityId);
        return view("mark-visited-city")->with("city", $city);
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

    /**
     * @param Request $request
     * @param RegionService $regionService
     * @param CountryService $countryService
     * @param VisitedCitiesService $visitedCitiesService
     * @param CityService $cityService
     * @return View
     */
    public function nextVisitedCity(
        Request $request,
        RegionService $regionService,
        CountryService $countryService,
        VisitedCitiesService $visitedCitiesService,
        CityService $cityService,
    ) : View {
        $countryName = "";
        $cityName = "";
        $regions = $regionService->getActiveRegions();
        $region = $request->get('region');
        if ($region) {
            $country = $countryService->getRandomCountry($region);
            $countryName = $country->name;
            $visitedCitiesIds = $visitedCitiesService->getVisitedCitiesIds(auth()->user()->id);
            $cityName = $cityService->getRandomCityName($country->id, $visitedCitiesIds);
        }

        return view("next-visited-city")
            ->with("regions", $regions)
            ->with("countryName", $countryName)
            ->with("cityName", $cityName);
    }
}
