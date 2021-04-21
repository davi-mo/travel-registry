@extends('overview')
@section('content')
    @include('main')
    <div id="form" class="form">
        <div id="next-city-section">
            <form id="form-regions" action="{{ route('nextVisitedCity') }}">
                <div class="form-group">
                    <label for="regionFormSelect">Region:</label>
                    <select id="regionFormSelect" name="region" aria-label="Active Regions" form="form-regions">
                        <option value=""></option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id }}" @if($region->id == $selectedRegionId) selected @endif>{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="Check your next travel">
                </div>
            </form>
            @if($countryName)
                <p>Suggestion of country to visit is: <b>{{ $countryName }}</b>.</p>
            @endif
            &nbsp;
            @if($cityName)
                <p>Suggestion of city to visit from <b>{{ $countryName }}</b> is: <b>{{ $cityName }}</b>.</p>
            @endif
            &nbsp;
            @if($selectedRegionId)
                <p>To generate a new suggestion click on the button <b>Check your next travel</b>.</p>
            @endif
        </div>
    </div>
@stop
