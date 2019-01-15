<template>            
<div style="display: flex; flex-direction: row;">
    <h5>Radius: </h5>
    <div class="slidecontainer" style="flex: 1; padding: 0.5rem;">
        <input type="range" min="1" max="20" class="slider" step="0.5" id="radiusSlider" :value="radius" @input="$emit('update:radius', $event.target.value)">
    </div>
    <h5>{{radius}} km</h5>
</div>
</template>
<script>
export default {
    props: ['radius'],
        mounted() {
            console.log('Radius slider mounted.');
        }
    }
</script>
<style scoped>
h5{
    margin-bottom: 0px;
    padding: 0.5rem;
    min-width: 100px;
}
.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 15px;
  border-radius: 5px;   
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  border-radius: 50%; 
  background: #4CAF50;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #4CAF50;
  cursor: pointer;
}
    
    
</style>