@extends('overview')
@section('content')
    @include('main')
    <div id="form" class="form">
        <form id="form-country" action="{{ route('updateCountry', ['countryId' => $country->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="countryName">Name:<span>*</span></label>
                <input id="countryName" type="text" name="name" value="{{ $country->name }}" class="form-control form-control-sm" form="form-country" required>
            </div>
            <div class="form-group">
                <label for="countryCode">Code:<span>*</span></label>
                <input id="countryName" type="text" name="code" value="{{ $country->code }}" class="form-control form-control-sm" form="form-country" required maxlength="2">
            </div>
            <div class="form-group">
                <label for="countryCapital">Capital:<span>*</span></label>
                <input id="countryCapital" type="text" name="capital" value="{{ $country->capital }}" class="form-control form-control-sm" form="form-country" required>
            </div>
            <div class="form-group">
                <label for="countryRegion">Region:<span>*</span></label>
                <input id="countryRegion" type="text" name="region" value="{{ $country->region?->name }}" class="form-control form-control-sm" form="form-country" required readonly>
            </div>
            <div class="form-group">
                <input type="submit" value="Save">
                <input type="button" value="Cancel" onclick="window.history.back(); return false;">
            </div>
        </form>
    </div>
@stop
