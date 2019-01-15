@extends('layouts.app')
@section('header')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLtgGpe40Edtcsvmor0jJIT3eM2XFhFE8"
async defer></script>
@endsection


@section('content')
<div class="container">
    <dashboard-component
    :user="{{ json_encode(Auth::user()) }}"
    ></dashboard-component>
</div>
@endsection