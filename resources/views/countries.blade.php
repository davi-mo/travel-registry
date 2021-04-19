@extends('overview')
@section('content')
    @include('main')
    <div id="form" class="form">
        <div id="countries-section">
            <div class="text-right link-back">
                <a href="{{ route('getAllRegions') }}">Back to region page</a>
            </div>
            <form action="{{ route('getCountriesByRegion', ['regionId' => $regionId]) }}">
                @csrf
                <div class="form-group">
                    <input id="filterCountryTerm" type="text" name="term" placeholder="Search for country names or codes.." title="Type in a name or a code">
                </div>
            </form>
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
                            <td class="text-center">
                                <a title="Edit the country {{ $country->name }}" href="{{ route('editCountryPage', ['countryId' => $country->id]) }}"><i class="fa fa-edit"></i></a>&nbsp;
                                <a title="Get the cities from country {{ $country->name }}" href="{{ route('getCitiesByCountry', ['countryId' => $country->id]) }}"><i class="fa fa-flag"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $countries->links() }}
            @endif
        </div>
    </div>
@stop
