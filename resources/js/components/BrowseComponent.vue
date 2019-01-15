<template>
    <div class="content" ref="content">
        <div class="filter-bar" ref="searchBar">
            <div class="filter-component">
                <search-bar-component 
                    :categories="categories" 
                    v-bind:selectedCategoryID.sync="selectedCategoryID"
                    v-bind:searchText.sync="searchText"
                ></search-bar-component>
            </div>
            <div class="filter-component"><radius-slider-component v-bind:radius.sync="radius"></radius-slider-component></div>
        </div>
        <div class="wrapper" id="main-content" ref="mainContent">
                <div class="mapcontainer" style="position: relative;">
                    <modal-component v-if="isModalVisible" @close="closeModal">
                        <template slot="header">Item details</template>
                        <template slot="body">
                            <div v-if="selectedItem" class="card" style="width: 100%;height:100%">
                                <img :src="'/uploads/' + selectedItem.imageurl" class="card-img-top">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mt-auto">{{selectedItem.name}}</h5>
                                    <p class="card-text">{{ selectedItem.description }}</p>
                                </div>
                            </div>
                        </template>
                        <template slot="footer">
                            <div v-if="user == null" class="alert alert-warning">
                                Login or Register to call Dibs!
                            </div>
                            <template v-else>
                                <div v-if="selectedItem.owner_id == user.id" class="alert alert-warning">You can't call dibs in your own items</div>
                                <div v-else>
                                    <div v-if="selectedItem.dibs_caller_id == null"><a href="" class="btn btn-primary">Call Dibs</a></div>
                                    <div v-else>
                                        <div v-if="selectedItem.dibs_caller_id == user.id" class="alert alert-success">Dibs called by you</div>
                                        <div v-else class="alert alert-warning">Dibs called by other user</div>
                                    </div>
                                </div>
                            </template>
                            <button class="modal-default-button" @click="closeModal">Close</button>
                        </template>
                    </modal-component>
                    <google-map-component
                        v-if="renderMap" :userlat="userlat" :userlng="userlng" @clickedMarker="handleMarkerClickInParent"
                    ></google-map-component>
                </div>
                <div class="sidecontainer" v-bind:style="sideColHeight" v-if="sideColHeight">
                    <div class="filter-bar" v-if="displayedItems" style="padding: 1rem;">
                        <p>{{displayedItems.length}} results found in your area</p>
                    </div>
                    <ul style="overflow: auto;" v-if="displayedItems">
                        <li v-for="item in filteredItems" style="margin-top: 15px; box-sizing: border-box;">
                            <section style="border-radius: 3px; background-color: #fff; box-shadow: 0 1px 3px 0 rgba(30,41,61,.1), 0 1px 2px 0 rgba(30,41,61,.2);">
                                <div style="height: 300px; width: 100%; text-align: center;">
                                    <img style="max-width:100%; max-height: 100%;" :src="'/uploads/' + item.imageurl">
                                </div>
                                <div class="item-details" style="display: flex;">
                                    <div style="padding: 18px;box-sizing: inherit; width: 250px; flex: 0 0 auto;">
                                        <h5 class="">{{item.name}}</h5>
                                        <p class="">{{ item.description }}</p>
                                    </div>
                                    <div style="padding: 18px 18px 12px;width: 328px; flex: 1 1 auto; display: flex; flex-direction: column; justify-content: space-around;">
                                        <button>Call Dibs</button>
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
                markersData: null,
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
                searchText: undefined // to-do
            };
        },
        computed: {
            filteredItems: function () {
                let items = this.displayedItems;
                if(this.searchText){
                    items = items.filter((p)=>{
                    return p.name.toLowerCase().indexOf(this.searchText.toLowerCase()) !== -1;
                    })
                }
                if(this.selectedCategoryID && this.selectedCategoryID != -1){
                    items = items.filter((p)=>{
                    return p.category_id == this.selectedCategoryID;
                    })
                }
                return items;
            }
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
        methods:
        {
            matchHeight (event) {
                let height = this.$refs.content.clientHeight - this.$refs.searchBar.clientHeight;
                var heightString = height + 'px';
                Vue.set(this.sideColHeight, 'height', heightString); 
            },
            getDisplayedItems(){
                //to-do: update this function to accept the appropriate params
                axios.get('/api/get_displayed_items')
                .then(response => { 
                    this.displayedItems = response.data.data
                }) //to-do: catch                
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
                    this.markersData = response.data.data
                    this.renderMap = true
                    this.getDisplayedItems()
                }) //to-do: catch
            },
            handleMarkerClickInParent: function(itemID){
                this.selectedItemID = itemID
                //console.log("Clicked parent: " + this.selectedItemID);
            }
        },
         beforeMount() {
            this.geolocation() // get user location before mounting the component
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
    .wrapper{
        display: grid;
        /*grid-template-columns: repeat(3, 1fr);*/
        grid-template-columns: auto 615px;
        grid-template-rows: 1fr;
    }
    .mapcontainer {
    }
    .sidecontainer{
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }
    .sidecontainer > ul {
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
    }
    
    .filter-component{
        padding: 1rem;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        flex: 1;
    }
    
</style>