@extends('overview')
@section('content')
    @include('main')
    <div id="form">
        <div>
            <p>To see the countries, select a region bellow:</p>
        </div>
        <form id="form-regions" action="{{ route('getCountriesByRegion') }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="regionFormSelect">Select a region:<span style="color: #ff0000">*</span></label>
                <select id="regionFormSelect" name="region" class="form-control form-control-sm" aria-label="Active Regions" form="form-regions" onchange="getCountries()" required>
                    <option value=""></option>
                    @foreach($regions as $region)
                        <option value="{{ $region->id }}" @if($region->id == $selectedRegionId) selected @endif>{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>&nbsp;
        <div id="countries-section">
            @if($selectedRegionId != 0)
                @if($countries->isEmpty())
                    <p>There are no countries for the selected region.</p>
                @else
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-left" scope="col">Name</th>
                            <th class="text-center" scope="col">Code</th>
                            <th class="text-center" scope="col">Capital</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($countries as $country)
                            <tr>
                                <td class="text-left">{{ $country->name }}</td>
                                <td class="text-center">{{ $country->code }}</td>
                                <td class="text-center">{{ $country->capital }}</td>
                                <td class="text-center"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            @endif
        </div>
    </div>
@stop
