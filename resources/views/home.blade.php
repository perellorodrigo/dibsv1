@extends('layouts.app')
@section('header')
<link href="{{  secure_asset('css/homespecial.css') }}" rel="stylesheet">
<script type="text/javascript">
    var userLocation;
    var markers = [];
    var map;
    var marker;
    
  	window.onload = function() {
  		if (navigator.geolocation) {
  			navigator.geolocation.getCurrentPosition(sendPosition);
  		} else {
  			$('<p>Geolocation is not supported by this browser.<p>').appendTo($('#userLocationBox'));;
  		}
  	}
  	function sendPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        
        $.ajax({
  				type: "POST",
  				url: "/get_user_position",
  				data : {'lat': latitude,
  				        'lng': longitude,
  				        '_token': $('meta[name="csrf-token"]').attr('content')},
  				success:function (data) {
  				  //alert('looks like it is working...');
  				  console.log("inside");
  				  $('#mapcontainer').empty();
  				  $('#mapcontainer').append(data);
  				  navigator.geolocation.getCurrentPosition(createMap);
  				  setupRange();
  				},
			});
  	}
    
  	function createMap(position) {
        userLocation = {lat: position.coords.latitude, lng: position.coords.longitude}; // Set user location
        
        map = new google.maps.Map(document.getElementById('map'), {
          center: userLocation, // Center of the map is the user location
          zoom: 10,
          disableDefaultUI: true
        });
  			
  		var usericon = '/uploads/user_marker.png';
  		marker = new google.maps.Marker({position: userLocation, map: map,icon: usericon}); // Add user location to map

      items.forEach(function(item) { //for each loop - goes through every item
        var point = new google.maps.LatLng(
                  parseFloat(item.lat),
                  parseFloat(item.lng));
               
        
        marker = new google.maps.Marker({
            map: map,
            distanceToUser: item.distanceToUser,
            position: point
          });
          
        marker.addListener('click', function(event) {
          $('#displayfield').empty();
          $('#displayfield').load('/home/' + item.id);
        });
        
        markers.push(marker);
      });
  	}
function setupRange(){
    var slider = document.getElementById("radiusSlider");
    var output = document.getElementById("displayRadius");
    output.innerHTML = slider.value + ' km'; // Display the default slider value
 
    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function() {
      output.innerHTML = this.value + ' km';
      var range = parseFloat(this.value);
      
      /* global markers */
      // For each marker:
      markers.forEach(function(markerElement) {
        
        /* global map */
        if (markerElement.get('distanceToUser') <= range)
          markerElement.setMap(map);
        else
          markerElement.setMap(null);
})}};
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLtgGpe40Edtcsvmor0jJIT3eM2XFhFE8"
async defer></script>

@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                  <h5 class="card-header">Radius:</h5>
                  <div class="card-body">
                      <div class="slidecontainer">
                          <input type="range" min="1" max="20" value="20" class="slider" step="0.5" id="radiusSlider">
                        </div>
                        <div>
                            <h3 id="displayRadius" style="text-align: center;"></h3>
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
          @include('common.messages')
        </div>
        </div>
        <div class="row">
          <div class="col-md-6" id="mapcontainer" style="height:500px;">
              
          </div>
          <div class="col-md-6" id="displayfield">
              
          </div>
        </div>
    </div>
</div>

@endsection



