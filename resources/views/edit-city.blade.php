@extends('overview')
@section('content')
    @include('main')
    <div id="form" class="form">
        <form id="form-city" action="{{ route('updateCity', ['cityId' => $city->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="cityName">Name:<span>*</span></label>
                <input id="cityName" type="text" name="name" value="{{ $city->name }}" class="form-control form-control-sm" form="form-city" required>
            </div>
            <div class="form-group">
                <label for="cityState">State:</label>
                <input id="cityState" type="text" name="state" value="{{ $city->state }}" class="form-control form-control-sm" form="form-city">
            </div>
            <div class="form-group">
                <label for="cityCountry">Country:<span>*</span></label>
                <input id="cityCountry" type="text" name="country" value="{{ $city->country?->name }}" class="form-control form-control-sm" form="form-city" required readonly>
            </div>
            <div class="form-group">
                <input type="submit" value="Save">
                <input type="button" value="Cancel" onclick="window.history.back(); return false;">
            </div>
        </form>
    </div>
@stop
