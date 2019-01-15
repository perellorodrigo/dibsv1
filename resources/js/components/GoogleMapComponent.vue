<template>
  <div class="google-map" id="googleMap">
    
  </div>
</template>
<script>
export default {
  props: ['userlat','userlng'], //to-do
  data: function () {
    return {
      mapName: 'googleMap',
      map: null,
      bounds: null,
      markers: []
    }
  },
  mounted: function () {
    this.bounds = new google.maps.LatLngBounds();
    const element = document.getElementById(this.mapName);
    
    const mapCentre = this.$parent.markersData[0];
    const options = {
      center: new google.maps.LatLng(mapCentre.lat, mapCentre.lng)
    };
    this.map = new google.maps.Map(element, options);
    this.$parent.markersData.forEach((coord) => { // Access parent component which contain the coordinates
      const position = new google.maps.LatLng(coord.lat, coord.lng)
      var marker = new google.maps.Marker({ 
        position,
        map: this.map,
        distanceToUser: coord.distanceToUser,
        id: coord.id,
        active: true
      });
      
      marker.addListener('click', () => this.childClick(coord.id));
      //this.$emit('clickedMarker',coord.id)
      
      this.markers.push(marker);
      this.map.fitBounds(this.bounds.extend(position));
    });
    
  },
  methods: {
    childClick: function (id) {
      this.$emit('clickedMarker',id)
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
        
        markers.forEach(function(marker) {
          let isActive = filteredItems.findIndex((c) => {
                return c.id === marker.id
            })
            marker.active = (isActive !== -1);
        });
        
        markers.forEach((marker) => {
          console.log(marker);
          if(marker.active == true){
    	      marker.setMap(this.map);
          }
      	 else{
      	   marker.setMap(null);
      	 }
        });
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