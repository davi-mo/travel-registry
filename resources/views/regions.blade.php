@extends('overview')
@section('content')
    @include('main')
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
                    <form action="{{ route('updateRegion', ['regionId' => $region->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn" @if($region->active == 0) title="Activate the region {{ $region->name }}" @else title="Inactivate the region {{ $region->name }}" @endif><i class="fa fa-check"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop
