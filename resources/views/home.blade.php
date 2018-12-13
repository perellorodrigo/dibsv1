@extends('layouts.app')
@section('header')
<link href="{{  secure_asset('css/homespecial.css') }}" rel="stylesheet">
<script type="text/javascript">

  	function getLocation() {
  		if (navigator.geolocation) {
  			navigator.geolocation.getCurrentPosition(createMap);
  		} else {
  			$('<p>Geolocation is not supported by this browser.<p>').appendTo($('#userLocationBox'));;
  		}
  	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLtgGpe40Edtcsvmor0jJIT3eM2XFhFE8&callback=getLocation"
async defer></script>
<script type="text/javascript">	
    var items = {!! json_encode($items) !!};
    var userLocation;
    var markers = [];
    var map;
    var marker;
    
  	function createMap(position) {
        userLocation = {lat: position.coords.latitude, lng: position.coords.longitude};; // Set user location
        
        
        map = new google.maps.Map(document.getElementById('map'), {
          center: userLocation, // Center of the map is the user location
          zoom: 12,
          disableDefaultUI: true
        });
  			
  		var usericon = '/uploads/user_marker.png';
  		marker = new google.maps.Marker({position: userLocation, map: map,icon: usericon}); // Add user location to map

      items.forEach(function(item) {
       var point = new google.maps.LatLng(
                parseFloat(item.lat),
                parseFloat(item.lng));
             
        //to-do: ideally, this should be rendered via template -> different view   
        var sideItemInfo = '<div id="'+ item.id  +'"><h1>'+ item.name + '</h1><img class="img-fluid" src="/uploads/' + item.imageurl +'"><p>'+ item.description +'</p></div>';
        
        
        marker = new google.maps.Marker({
          map: map,
          position: point
        });
        
      marker.addListener('click', function(event) {
        $('#displayfield').empty();
        
        $('#displayfield').load('/home/' + item.id);
        
        //$(sideItemInfo).appendTo($('#displayfield')) // to-do: call function that will render according to data
      });
      
      
      markers.push(marker);
      });
  	}
</script>
<script type="text/javascript">
window.onload = function(){
    var slider = document.getElementById("radiusSlider");
    var output = document.getElementById("displayRadius");
    output.innerHTML = slider.value + ' km'; // Display the default slider value
 
    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function() {
      output.innerHTML = this.value + ' km';
      var range = parseFloat(this.value);

      // For each marker:
      markers.forEach(function(markerElement) {
        //var markerPosition = markerElement.getPosition;
        var markerLat = markerElement.getPosition().lat();
        var markerLng = markerElement.getPosition().lng();
        
        var distance = getDistance(userLocation.lng, userLocation.lat, markerLng, markerLat);
        
        if (distance <= range)
        {
          markerElement.setMap(map);
        }
        else
        {
          markerElement.setMap(null);
        }
        
        // Got from stackoverflow:
        function getDistance(lat1, lon1, lat2, lon2) {
          var R = 6371; // Radius of the earth in km
          var dLat = (lat2 - lat1) * Math.PI / 180;  // deg2rad below
          var dLon = (lon2 - lon1) * Math.PI / 180;
          var a = 
             0.5 - Math.cos(dLat)/2 + 
             Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
             (1 - Math.cos(dLon))/2;
          
          return R * 2 * Math.asin(Math.sqrt(a));
        }
})}};
</script>

@endsection
@section('content')
<div class="container">
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
          
        </div>
        <div class="col-md-6">
            <div id="map" style="height:400px;"></div>
        </div>
        <div class="col-md-6" id="displayfield">
            
        </div>
    </div>
</div>

@endsection



