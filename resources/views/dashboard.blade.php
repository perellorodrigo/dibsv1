@extends('layouts.app')
@section('header')
<style type="text/css">
    .card-img-top {
    width: 100%;
    height: 15vw;
    object-fit: cover;
    }

</style>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
    
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        @foreach ($items as $item)
        <div class="col-md-3"><!-- Todo -->
            <div class="card" style="width: 100%;height:100%">
                <img src="/uploads/{{$item->imageurl}}" class="card-img-top">
              <div class="card-body d-flex flex-column">
                <h5 class="card-title mt-auto">{{$item->name}}</h5>
                <p class="card-text">{{ $item->description }}</p>
                
              </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection