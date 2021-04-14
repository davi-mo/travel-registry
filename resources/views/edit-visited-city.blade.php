@extends('overview')
@section('content')
    @include('main')
    <div id="form" class="form">
        <form id="form-visited-city" action="{{ route('updateVisitedCity', ['visitedCityId' => $visitedCity->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="cityName">Visited City:</label>
                <input id="cityName" type="text" value="{{ $visitedCity?->city?->name }}" class="form-control form-control-sm" form="form-visited-city" readonly>
            </div>
            <div class="form-group">
                <label for="countryName">Visited Country:</label>
                <input id="countryName" type="text" value="{{ $visitedCity?->city?->country?->name }}" class="form-control form-control-sm" form="form-visited-city" readonly>
            </div>
            <div class="form-group">
                <label for="visitedAt">Visited At:</label>
                <input id="visitedAt" type="date" name="visitedAt" value="{{ $visitedCity->visited_at }}" class="form-control form-control-sm" form="form-visited-city">
            </div>
            <div class="form-group">
                <input type="submit" value="Save">
                <input type="button" value="Cancel" onclick="window.history.back(); return false;">
            </div>
        </form>
    </div>
@stop
