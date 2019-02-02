@extends('layouts.app')
@section('header')

@endsection

@section('content')
<div class="container">
    <manage-items-view :user="{{ json_encode(Auth::user()) }}"></manage-items-view>
</div>
@endsection