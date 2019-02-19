@extends('layouts.app')
@section('header')

@endsection

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body">
                    <h5><span style="font-weight: bold;">Name:</span> {{ Auth::user()->name }}</h5>
                    <h5><span style="font-weight: bold;">Email:</span> {{ Auth::user()->email }}</h5>
                    <h5><span style="font-weight: bold;">Approval Rating:</span> {{ Auth::user()->approval_rating }}</h5>
                    
                </div>
            </div>
            <div class="card mt-4">
                @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-header">Change Password</div>
                <div class="card-body">
                    <form action="{{ route('changePassword') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                        {{ csrf_field() }}
                    <div class="form-group">
                        <label for="current-password" class="col-sm-3 control-label">Current Password</label>
                        <div class="col-sm-6">
                            <input type="password" name="current-password" id="current-password" class="form-control" required>
                            @if ($errors->has('current-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new-password" class="col-sm-3 control-label">New Password</label>
                        <div class="col-sm-6">
                            <input type="password" name="new-password" id="new-password" class="form-control" required>
                            @if ($errors->has('new-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new-password-confirm" class="col-sm-3 control-label">Confirm New Password</label>
                        <div class="col-sm-6">
                            <input type="password" name="new-password_confirmation" id="new-password-confirm" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Change Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection