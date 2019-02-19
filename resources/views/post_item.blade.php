@extends('layouts.app')
@section('header')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLtgGpe40Edtcsvmor0jJIT3eM2XFhFE8"
async defer></script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Item</div>
                <div class="card-body">
                    <add-item-component :user="{{ json_encode(Auth::user()) }}"></add-item-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection