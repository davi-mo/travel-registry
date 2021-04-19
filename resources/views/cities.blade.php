@extends('overview')
@section('content')
    @include('main')
    <div id="form" class="form">
        <div id="cities-section">
            <div class="text-right link-back">
                <a href="{{ route('getCountriesByRegion', ['regionId' => $country->region_id]) }}">Back to country page</a>
            </div>
            @if($cities->isEmpty())
                <p>There are no cities for the country {{ $country->name }}.</p>
            @else
                <form action="{{ route('getCitiesByCountry', ['countryId' => $country->id]) }}">
                    @csrf
                    <div class="form-group">
                        <input id="filterCityName" type="text" name="name" placeholder="Search for city names.." title="Type in a name">
                    </div>
                </form>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-left" scope="col">Name</th>
                        <th class="text-left" scope="col">State</th>
                        <th class="text-center" scope="col">Country</th>
                        <th class="text-center" scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cities as $city)
                        <tr>
                            <td class="text-left">{{ $city->name }}</td>
                            <td class="text-left">{{ $city->state }}</td>
                            <td class="text-center">{{ $city->country?->name }}</td>
                            <td class="text-center">
                                <a title="Edit the city {{ $city->name }}" href="{{ route('editCityPage', ['cityId' => $city->id]) }}"><i class="fa fa-edit"></i></a>&nbsp;
                                <a title="Mark city {{ $city->name }} as visited" href="{{ route('markVisitedCity', ['cityId' => $city->id]) }}"><i class="fa fa-calendar"></i></a>&nbsp;
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $cities->links() }}
            @endif
        </div>
    </div>
@stop
