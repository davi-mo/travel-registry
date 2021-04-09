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
                </tr>
                </thead>
                <tbody>
                @foreach($visitedCities as $visitedCity)
                    <tr>
                        <td class="text-left">{{ $visitedCity->city?->name }}</td>
                        <td class="text-left">{{ $visitedCity->city?->country?->name }}</td>
                        <td class="text-left">{{ $visitedCity->visited_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@stop
