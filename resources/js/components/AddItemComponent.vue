<template>
    <div style="display: flex; flex-direction: column;">
    <form enctype="multipart/form-data" @submit.prevent="formSubmit">
        <div v-if="success != ''" class="alert alert-success" role="alert">
          {{success}}
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Name</label>
            <input type="text" class="form-control" v-model="name">
        </div>
        <div class="form-group">  
            <label for="description" class="col-sm-3 control-label">Description</label>
            <input type="text" class="form-control" v-model="description">
        </div>
        
        <div class="form-group">  
        <label for="category" class="col-sm-3 control-label">Category:</label>
        <select v-model="selectedCategory" class="form-control">
            <option v-for="item in categories" v-bind:value="item.id">
            {{item.name}}
            </option>
        </select>
        </div>
        <div class="form-group">  
            <label for="pickup_instructions" class="col-sm-3 control-label">Pick-up Instructions</label>

            <input type="text" class="form-control" v-model="pickupInstructions">
        </div>   
        
        <div class="form-group">
            <button @click="getUserLocation" type="button" class="btn btn-dark">
            Get Current Location
            </button>
        </div>
        <div class="form-group">
            <input type="number"  class="form-control" placeholder="latitude" step="any" v-model="latitude">
            <input type="number"  class="form-control" placeholder="longitude" step="any" v-model="longitude">
        </div>
    
        <div class="form-group">
            <label for="picture" class="col-sm-3 control-label">Upload Picture:</label>
            <input type="file" id="picture" class="form-control-file" v-on:change="onImageChange" ref="imageInput">
        </div>
        <!-- Add Task Button -->

        <button type="submit" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Product
        </button>
    </form>
    <div>

    </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    props: ['user'],
    data: function () {
        return{
            name: null,
            description: null,
            pickupInstructions: null,
            latitude: null,
            longitude: null,
            image: null,
            success: '',
            categories: null,
            selectedCategory: null,
            files: null
        }
    },
    mounted() {
        axios.get('/get_categories')
        .then(response => {
            this.categories = response.data.data;
        });
    },
    methods: {
        getUserLocation(){
            navigator.geolocation.getCurrentPosition(this.geoSuccess, this.geoError);
        },
        geoSuccess(position) { // if sucessfully got user coordinates
            this.latitude = position.coords.latitude
            this.longitude = position.coords.longitude
        },
        geoError(error) {
            //if error, display error and use fake coordinates
            console.log(error);
            this.latitude = -33.882885699999996
            this.longitude = 151.2011262
        },
        onImageChange(e){
            console.log(e.target.files[0]);
            this.image = e.target.files[0];            
        },
        formSubmit(e){
            //e.preventDefault();
            let currentObj = this;
            
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            
            let formData = new FormData();
            formData.append('name', this.name);
            formData.append('description', this.description);
            formData.append('selected_category', this.selectedCategory);
            formData.append('pickup_instructions', this.pickupInstructions);
            formData.append('latitude', this.latitude);
            formData.append('longitude', this.longitude);
            formData.append('image', this.image);
            formData.append('owner_id', this.user.id);
            
            axios.post('/post_item/add_item', formData, config)
                .then((response) => {
                    currentObj.success = response.data.success;
                    this.resetForm();
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
        },
        resetForm(){
            this.name = '';
            this.description = '';
            this.pickupInstructions = '';
            this.latitude = '';
            this.longitude = '';
            this.image = null;
            this.$refs.imageInput.value = null;
        }
        
    }
};
    
    
</script>