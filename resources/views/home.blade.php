@extends('overview')
@section('content')
<div id="main" class="main">
    <div class="text-right"><h6>User: {{ $user->name }}</h6></div>
    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
</div>
@stop
