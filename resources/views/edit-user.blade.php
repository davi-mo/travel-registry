@extends('overview')
@section('content')
    @include('main')
    <div id="form" class="form">
        <form id="form-user" action="{{ route('updateUser', ['userId' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="userName">Name:<span>*</span></label>
                <input id="userName" type="text" name="name" value="{{ $user->name }}" class="form-control form-control-sm" form="form-user" required>
            </div>
            <div class="form-group">
                <label for="userEmail">Email:<span>*</span></label>
                <input id="userEmail" type="text" value="{{ $user->email }}" class="form-control form-control-sm" form="form-user" required readonly>
            </div>
            <div class="form-group">
                <input type="submit" value="Save">
                <input type="button" value="Cancel" onclick="window.history.back(); return false;">
            </div>
        </form>
    </div>
@stop
