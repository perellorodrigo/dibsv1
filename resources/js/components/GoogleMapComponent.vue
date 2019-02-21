<template>
  <div class="google-map" :id="mapName">
    
  </div>
</template>
<script>
export default {
  props: ['userlat','userlng','radius'], //to-do
  data: function () {
    return {
      mapName: 'googleMap',
      map: null,
      userPosition: null,
      bounds: null,
      circle: null,
      markers: []
    }
  },
  mounted: function () {
    this.setupMap();
    this.userPosition = new google.maps.LatLng(this.userlat, this.userlng);
    const position = this.userPosition;
    var marker = new google.maps.Marker({ 
              position,
              map: this.map,
              icon: '/uploads/user_marker.png'
              });
    
    this.setupMarkers();
    this.setupRadiusCircle();
  },
  methods: {
    markerClick: function (id) {
      this.$emit('clickedMarker',id)
    },
    setupMarkers: function() {
      this.$parent.displayedItems.forEach((item) => { // Access parent component which contain the coordinates
        const position = new google.maps.LatLng(item.lat, item.lng)
        var marker = new google.maps.Marker({ 
                      position,
                      map: this.map,
                      distanceToUser: item.distanceToUser,
                      id: item.id
                      });
        
        marker.addListener('click', () => this.markerClick(item.id));
        this.markers.push(marker);
        this.map.fitBounds(this.bounds.extend(position));
      });
    },
    setupMap: function(){
      this.bounds = new google.maps.LatLngBounds();
      const element = document.getElementById(this.mapName);
      
      const mapCentre = this.$parent.displayedItems[0];
      const options = {
        center: new google.maps.LatLng(mapCentre.lat, mapCentre.lng),
                            disableDefaultUI: true
      };
      this.map = new google.maps.Map(element, options);
    },
    setupRadiusCircle: function (){
      this.circle = new google.maps.Circle({
          strokeColor: '#53A7FF',
          strokeOpacity: 0.8,
          strokeWeight: 2,
          fillColor: '#53A7FF',
          fillOpacity: 0.35,
          map: this.map,
          center: this.userPosition,
          radius: this.radius * 1000
          });
    }
  },
  computed: {
    displayedMarkers: function (){
      return this.$parent.filteredItems;
    }
  },
  watch: {
    displayedMarkers: function () {
      let markers = this.markers;
      let filteredItems = this.displayedMarkers;
        
      markers.forEach((marker) => {
        let isActive = filteredItems.findIndex((c) => {
              return c.id === marker.id
          })
          marker.setMap((isActive !== -1) ? this.map : null);
      });
    },
    radius: function(){
      if (this.circle)
        this.circle.setRadius(this.radius * 1000)
      else 
          this.setupRadiusCircle()
    }
  }
};
</script>
<style scoped>
.google-map {
  width: 100%;
  height: 100%;
  margin: 0 auto;
  background: gray;
}
</style>