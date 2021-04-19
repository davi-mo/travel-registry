@extends('overview')
@section('content')
    @include('main')
    <div id="form" class="form">
        @if($visitedCities->isEmpty())
            <p>There are no visited cities at the moment.</p>
        @else
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="text-left" scope="col">City Name</th>
                    <th class="text-left" scope="col">Country Name</th>
                    <th class="text-left" scope="col">Visited At</th>
                    <th class="text-center" scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($visitedCities as $visitedCity)
                    <tr>
                        <td class="text-left">{{ $visitedCity->city?->name }}</td>
                        <td class="text-left">{{ $visitedCity->city?->country?->name }}</td>
                        <td class="text-left">{{ $visitedCity->formattedVisitedAt() }}</td>
                        <td class="text-center">
                            <div class="btn-group mr-2" role="group">
                                <form action="{{ route('deleteVisitedCity', ['visitedCityId' => $visitedCity->id]) }}" onsubmit="return confirm('Do you really want to delete this visited city?');" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" id="remove_{{$visitedCity->id}}" title="Remove the visited city {{ $visitedCity->city?->name }}"><i class="fa fa-trash"></i></button>
                                </form>
                                <form action="{{ route('editVisitedCity', ['visitedCityId' => $visitedCity->id]) }}">
                                    <button type="submit" class="btn" id="edit_visited_city_{{$visitedCity->id}}" title="Edit the visited city {{ $visitedCity?->city?->name }}"><i class="fa fa-edit"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@stop
