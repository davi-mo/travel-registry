<?php

namespace App\Http\Controllers;

use App\Services\VisitedCitiesService;
use Illuminate\Contracts\View\View;

class VisitedCityController extends Controller
{
    public function getByUser(VisitedCitiesService $visitedCitiesService) : View
    {
        $visitedCities = $visitedCitiesService->getByUser(auth()->user()->id);
        return view("visited-cities")->with("visitedCities", $visitedCities);
    }
}
