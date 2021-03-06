<?php

namespace App\Http\Controllers;

use App\Models\VisitedCities;
use App\Services\CityService;
use App\Services\VisitedCitiesService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VisitedCityController extends Controller
{
    /**
     * @param VisitedCitiesService $visitedCitiesService
     * @return View
     */
    public function getByUser(VisitedCitiesService $visitedCitiesService) : View
    {
        $visitedCities = $visitedCitiesService->getByUser(auth()->user()->id);
        return view("visited-cities")->with("visitedCities", $visitedCities);
    }

    /**
     * @param string $visitedCityId
     * @param VisitedCitiesService $visitedCitiesService
     * @return View
     */
    public function editVisitedCity(string $visitedCityId, VisitedCitiesService $visitedCitiesService) : View
    {
        $visitedCity = $visitedCitiesService->getById($visitedCityId);
        return view("edit-visited-city")->with("visitedCity", $visitedCity);
    }

    /**
     * @param string $cityId
     * @param Request $request
     * @param CityService $cityService
     * @param VisitedCitiesService $visitedCitiesService
     * @return RedirectResponse
     */
    public function saveVisitedCity(
        string $cityId,
        Request $request,
        CityService $cityService,
        VisitedCitiesService $visitedCitiesService
    ) : RedirectResponse {
        $visitedCity = new VisitedCities();
        $city = $cityService->getById($cityId);
        $user = auth()->user();
        $visitedAt = $request->get('visitedAt');
        $visitedCitiesService->saveVisitedCity($visitedCity, $city, $user, $visitedAt);

        return redirect()->to("/visited-cities");
    }

    /**
     * @param string $visitedCityId
     * @param Request $request
     * @param VisitedCitiesService $visitedCitiesService
     * @return RedirectResponse
     */
    public function updateVisitedCity(
        string $visitedCityId,
        Request $request,
        VisitedCitiesService $visitedCitiesService
    ) : RedirectResponse {
        $visitedCity = $visitedCitiesService->getById($visitedCityId);
        $visitedAt = $request->get('visitedAt');
        $visitedCitiesService->updateVisitedCity($visitedCity, $visitedAt);
        return redirect()->to('/visited-cities');
    }

    /**
     * @param string $visitedCityId
     * @param VisitedCitiesService $visitedCitiesService
     * @return RedirectResponse
     * @throws \Exception
     */
    public function deleteVisitedCity(
        string $visitedCityId,
        VisitedCitiesService $visitedCitiesService
    ) : RedirectResponse {
        $visitedCity = $visitedCitiesService->getById($visitedCityId);
        $visitedCitiesService->deleteVisitedCity($visitedCity);
        return redirect()->to('/visited-cities');
    }
}
