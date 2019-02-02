@extends('layouts.app')
@section('header')

@endsection

@section('content')
<div class="container">
    <chat-view :user="{{ json_encode(Auth::user()) }}"></chat-view>
</div>
@endsection