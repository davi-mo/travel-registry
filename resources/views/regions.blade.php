@extends('overview')
@section('content')
    @include('main')
    <div id="form" class="form">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-left" scope="col">Name</th>
                    <th class="text-center" scope="col">Active</th>
                    <th class="text-center" scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($regions as $region)
                <tr>
                    <td class="text-left">{{ $region->name }}</td>
                    <td class="text-center">{{ $region->activeCustomized() }}</td>
                    <td class="text-center">
                        <form action="{{ route('updateRegion', ['regionId' => $region->id]) }}" style="display: inline-block"  method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn" @if($region->active == 0) title="Activate the region {{ $region->name }}" @else title="Inactivate the region {{ $region->name }}" @endif><i class="fa fa-check"></i></button>
                        </form>
                        <a title="Get the countries from region {{ $region->name }}" href="{{ route('getCountriesByRegion', ['regionId' => $region->id]) }}"><i class="fa fa-globe"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
