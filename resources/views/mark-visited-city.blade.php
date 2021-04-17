@extends('overview')
@section('content')
    @include('main')
    <div id="form" class="form">
        <form id="form-city-visited" action="{{ route('saveVisitedCity', ['cityId' => $city->id]) }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="cityName">City:</label>
                <input id="cityName" type="text" value="{{ $city->name }}" class="form-control form-control-sm" form="form-city-visited" readonly>
            </div>
            <div class="form-group">
                <label for="visitedAt">Visited At:</label>
                <input id="visitedAt" type="date" name="visitedAt" class="form-control form-control-sm" form="form-city-visited">
            </div>
            <div class="form-group">
                <input type="submit" value="Save">
                <input type="button" value="Cancel" onclick="window.history.back(); return false;">
            </div>
        </form>
    </div>
@stop
