<template>
    <div class="content" ref="content">
        <div class="filter-bar" ref="searchBar">
            <div class="filter-component">
                <search-bar-component 
                    :categories="categories" 
                    v-if="categories"
                    v-bind:selectedCategoryID.sync="selectedCategoryID"
                    v-bind:searchText.sync="searchText"
                ></search-bar-component>
            </div>
            <div class="filter-component">
                <radius-slider-component
                    v-bind:radius.sync="radius">
                </radius-slider-component>
            </div>
        </div>
        <div class="wrapper">
                <div class="mapcontainer" style="position: relative;">
                    <modal-component v-if="isModalVisible" @close="closeModal">
                        <template slot="header">Item details</template>
                        <template slot="body">
                            <div v-if="selectedItem" class="" style="width: 100%;height:100%;display:flex; flex-direction: column;justify-content: space-between;">
                                <div style="flex: 1 1 auto; text-align: center;">
                                    <img :src="'/uploads/' + selectedItem.imageurl" style="max-height: 100%; max-width:100%;">
                                </div>
                                <div class="card-body d-flex flex-column" style="flex:0 0 auto;">
                                    <h5 class="card-title mt-auto">{{selectedItem.name}}</h5>
                                    <p class="card-text">{{ selectedItem.description }}</p>
                                </div>
                            </div>
                        </template>
                        <template slot="footer">
                            <call-dibs
                                :user="user"
                                :selectedItem="selectedItem"
                            ></call-dibs>
                            <button class="modal-default-button" @click="closeModal">Close</button>
                        </template>
                    </modal-component>
                    <google-map-component
                        v-if="renderMap"
                        :userlat="userlat"
                        :userlng="userlng"
                        @clickedMarker="handleMarkerClickInParent"
                        :radius="radius"
                    ></google-map-component>
                </div>
                <div class="side-container" v-bind:style="sideColHeight" v-if="sideColHeight">
                    <div class="filter-bar" v-if="displayedItems" style="padding: 1rem;">
                        <p>{{filteredItems.length}} displayed of total {{displayedItems.length}} results found in your area</p>
                    </div>
                    <ul class="item-list-container" v-if="displayedItems">
                        <li v-for="item in filteredItems" :key="item.id" style="margin-top: 15px; box-sizing: border-box;">
                            <section class="item-list-container">
                                <div style="height: 300px; width: 100%; text-align: center;">
                                    <img style="max-width:100%; max-height: 100%;" :src="'/uploads/' + item.imageurl">
                                </div>
                                <div class="item-list-details">
                                    <div class="item-list-details-text">
                                        <h5>{{item.name}}</h5>
                                        <p>{{ item.description }}</p>
                                    </div>
                                    <div class="item-list-details-button">
                                        <call-dibs
                                            :user="user"
                                            :selectedItem="item"
                                            @calledDibs="handleDibsCallInParent"
                                        ></call-dibs>
                                    </div>
                                </div>
                            </section>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
</template>
<script>
import axios from 'axios';
    export default {
        props: ['user'],
        data() {
            return {
                userlat: null,
                userlng: null,
                radius: 20, //Default radius is maximum (20km)
                selectedItemID: null,
                selectedItem: null,
                renderMap: false,
                isModalVisible: false,
                displayedItems: null,
                sideColHeight: { },
                categories: null, 
                selectedCategoryID: -1, // to-do
                searchText: '' // to-do
            };
        },
        beforeMount() {
            this.geolocation() // get user location before mounting the component
        },
        mounted() {
            axios.get('/api/get_categories')
            .then(response => {
                this.categories = response.data.data.concat(Object.assign({}, {name: 'Category', id: -1}));
            });
            this.matchHeight();
            this.$nextTick(() => {
              window.addEventListener('resize', () => {
                this.matchHeight();
              });
            })
        },
        computed: {
            filteredItems: function () {
                let items = this.displayedItems;
                // Filter by search text:
                if(this.searchText){
                    items = items.filter((item)=>{
                    return (item.name.toLowerCase().indexOf(this.searchText.toLowerCase()) !== -1) || (item.description.toLowerCase().indexOf(this.searchText.toLowerCase()) !== -1);
                    })
                }
                //---------------------
                // Filter by Category:
                if(this.selectedCategoryID && this.selectedCategoryID != -1){
                    items = items.filter((p)=>{
                    return p.category_id == this.selectedCategoryID;
                    })
                }
                //---------------------
                // Filter by Radius:
                if(this.radius)
                {
                    items = items.filter((p)=>{
                    return p.distanceToUser <= this.radius;
                    })
                }
                //---------------------
                return items;
            }
        },
        methods:
        {
            matchHeight (event) {
                let height = this.$refs.content.clientHeight - this.$refs.searchBar.clientHeight;
                var heightString = height + 'px';
                Vue.set(this.sideColHeight, 'height', heightString); 
            },
            showModal() {
                this.isModalVisible = true;
            },
            closeModal() {
                this.selectedItemID = null;
                this.isModalVisible = false;
            },
            geolocation() {
                navigator.geolocation.getCurrentPosition(this.geoSuccess, this.geoError);
            },
            geoSuccess(position) { // if sucessfully got user coordinates
                this.userlat = position.coords.latitude
                this.userlng = position.coords.longitude
                this.getMarkers()
            },
            geoError(error) {
                //if error, display error and use fake coordinates
                console.log(error);
                this.userlat = -33.882885699999996
                this.userlng = 151.2011262
                this.getMarkers()
            },
            getMarkers(){
                //axios GET request to pick the coordinates of items
                axios.get('/api/get_markers', {
                  params: {
                    'lat': this.userlat,
      		        'lng': this.userlng
                  }
                })
                .then(response => {
                    this.displayedItems = response.data.data;
                    this.renderMap = true
                }) //to-do: catch
            },
            handleMarkerClickInParent: function(itemID){
                this.selectedItemID = itemID
            },
            handleDibsCallInParent: function(itemID){
                this.renderMap = false;
                this.getMarkers();
            }
        },
        watch: {
            selectedItemID: function () {  //Whenever selectedItemID changes, this function will run
                if (this.selectedItemID == null)
                    this.selectedItem = null
                else
                {
                    axios.get('/api/item/' + this.selectedItemID)
                    .then(response => {
                        this.selectedItem = response.data
                        this.isModalVisible = true
                    }) //To-do: catch
                }
            }
        }
    }
</script>
<style scoped>
@media only screen and (max-width: 700px) {
    .wrapper{
        grid-template-columns: 0 100%;
    }
    .filter-component{
        flex-grow: 1;
    }
    .item-list-container{
        padding-inline-start: 0;
    }
}
@media only screen and (min-width: 700px) {
    .wrapper{
        grid-template-columns: auto 615px;
        
    }
    .filter-component{
        flex: 1;
    }
}
.item-list-container{
    overflow: auto;
    
}

.filter-component{
    padding: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: space-around;
}
.wrapper{
    display: grid;
    grid-template-rows: 1fr;
}
.side-container{
    display: flex;
    flex-direction: column;
    align-items: stretch;
}
.side-container > ul {
    list-style: none;
}

.content{
    display: grid;
    grid-template-rows: auto 1fr;
    height: 100%;
}
.filter-bar{
    background-color: #f2f5f7;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
}


.item-list-container{
    border-radius: 3px;
    background-color: #fff;
    box-shadow: 0 1px 3px 0 rgba(30,41,61,.1), 0 1px 2px 0 rgba(30,41,61,.2);
}
.item-list-details{
    display: flex;
    flex-direction: column;
}

.item-list-details-text{
    padding: 18px;
    box-sizing: inherit;
    width: 250px;
    flex: 0 0 auto;
}
.item-list-details-button{
    padding: 18px 18px 12px;
    flex: 1 1 auto; 
    display: flex; 
    flex-direction: column; 
    justify-content: space-around;
}
</style>