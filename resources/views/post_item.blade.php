@extends('layouts.app')

@section('content')

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script type="text/javascript">
  	function getLocation() {
  		if (navigator.geolocation) {
  			navigator.geolocation.getCurrentPosition(fillDetails);
  		} else {
  			$('<p>Geolocation is not supported by this browser.<p>').appendTo($('#userLocationBox'));;
  		}
  	}
  	function fillDetails(position) {
        var x = document.getElementById("itemlat");
        x.value = position.coords.latitude;
        x = document.getElementById("itemlng");
        x.value = position.coords.longitude;
}
  </script>




<div class="panel-body">
        <!-- Display Validation Errors -->
       @include('common.errors')

        <!-- New Task Form -->
    <form action="/post_item" method="POST" class="form-horizontal" enctype="multipart/form-data">
        {{ csrf_field() }}

        <!-- Task Name -->
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-6">
                <input type="text" name="name" id="name" class="form-control">
            </div>
        </div>
        <div class="form-group">  
            <label for="description" class="col-sm-3 control-label">Description</label>

            <div class="col-sm-6">
                <input type="text" name="description" id="description" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="location" class="col-sm-3 control-label">Item Location</label>
            <div class="col-sm-6">
                <input type="number" name="itemlat" id="itemlat" class="form-control" placeholder="latitude" step="any">
                <input type="number" name="itemlng" id="itemlng" class="form-control" placeholder="longitude" step="any">
                <button type="button" onclick="getLocation()" class="btn btn-default"> <i class="fa fa-plus"></i> Get Coordinates</button>
            </div>
        </div>
                
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <label for="picture" class="col-sm-3 control-label">Upload Picture:</label>
                <input type="file" name="picture" id="picture" class="form-control-file">
            </div>
        </div>
        <!-- Add Task Button -->
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
                <button type="submit" class="btn btn-default">
                    <i class="fa fa-plus"></i> Add Product
                </button>
            </div>
        </div>
    </form>
</div>
@endsection