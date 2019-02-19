<template>
    <div class="wrapper">
        <div id="side-bar">
            <p class="side-bar-title">Manage Items</p>
            <ul>
                <li><a href="#" @click="selectedFilter = 'displayAvailable'">Available</a></li>
                <li><a href="#" @click="selectedFilter = 'displayAwaiting'">Awaiting Pick-up</a></li>
                <li><a href="#" @click="selectedFilter = 'displayHistory'">History</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="card card-default">
                <div class="card-header">{{header}}</div>

                <div class="card-body">
                    <section v-if="items.length" class="item-section mt-4">
                        <template v-for="item in items">
                            <div class="card">
                                <div class="item-header" v-show="showHeader">
                                    <div class="delete-icon" @click="toBeArchivedID = item.id">
                                        <img src="svg/close.svg">
                                    </div>
                                    <button href="#" class="btn btn-danger delete-button" v-show="item.id === toBeArchivedID" @click="archiveItem(item.id)">
                                        Mark as unavailable
                                    </button>
                                </div>
                                <img :src="'/uploads/' + item.imageurl" class="card-img-top">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mt-auto">{{item.name}}</h5>
                                    <p class="card-text">{{ item.description }}</p>
                                </div>
                            </div>
                        </template>
                    </section>
                    <div v-else class="alert alert-warning" role="alert">
                          No items were found!
                    </div>
                </div>
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
            items: [],
            selectedFilter: "displayAvailable",
            header: "Available Items",
            toBeArchivedID: null,
            showHeader: true,
            params: "get_available"
        };
    },
    mounted() {
        axios.get('/manage_items/get_available')
            .then(response => {
                this.items = response.data;
                console.dir(this.items)
        })
        
    },
    methods:{
        archiveItem: function(itemID){
            console.log("Archieve Item: " + itemID);
            axios.post('/manage_items/archive_item/' + itemID)
                .then(response => {
                alert(response.data.message);
                axios.get('/manage_items/' + this.params)
                .then(response => {
                    this.items = response.data;
                    console.dir(this.items)
                })
            }) 
        }  
    },
    watch:{
        selectedFilter: function(){
            this.params = "get_available";
            console.log("Called, selected filter: " + this.selectedFilter);
            switch(this.selectedFilter) {
                case "displayAvailable":
                    this.params = "get_available"
                    this.showHeader = true
                    this.header = "Available Items"
                break;
                case "displayAwaiting":
                    this.params = "get_awaiting"
                    this.showHeader = true
                    this.header = "Awaiting Pickup"
                break;
                case "displayHistory":
                    this.params = "get_history"
                    this.showHeader = false
                    this.header = "History"
                break;
            }
            axios.get('/manage_items/' + this.params)
                .then(response => {
                    this.items = response.data;
                    console.dir(this.items)
            })
        }
    }
}
</script>
<style scoped>
    .wrapper{
        display: grid;
        grid-template-columns: 230px auto;
        margin-top: 1rem;
    }
    .main-content{
        margin: 0 0 0 1rem;
    }
    .main-content > .card{
        width: 100%;
    }
    
    .item-section{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-around;
    }
    .item-section > div{
        margin: 1rem 1rem 0 1rem;
        flex-basis: calc(33% - 2rem);
    }
    @media only screen and (max-width: 1200px) {
        .item-section > div{
            flex-basis: calc(50% - 2rem);
        }
    }
    @media only screen and (max-width: 1000px) {
        .item-section > div{
            flex-basis: calc(100% - 2rem);
        }
    }

    @media only screen and (max-width: 770px) {
        .wrapper{
            display: flex;
            flex-direction: column;
            margin-top: 1rem;
        
        }
        .main-content{
            margin: 1rem 0 0 0;
        }
        .item-section > div{
            flex-basis: calc(100% - 2rem);
        }
        
    }
    
    .item-header{
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 40px;
        box-sizing: border-box;
        margin-bottom: 1rem;
    }
    .delete-button{
        height: 100%;
    }
    .delete-button > img{
        height: 100%;
        padding: 5px 0px 5px 0;
        
    }
    .delete-icon{
        height: 100%;
    }
    .delete-icon > img{
        height: 100%;
        padding: 5px 10px 5px 0;
    }
    
    #side-bar{
        box-shadow: 0 2px 4px 0 rgba(0,0,0,.1);
    }
    
    #side-bar > ul {
        display: block;
        padding: 16px 0 0 30px;
        margin: 0 16px;
        list-style-type: none;
    }
    #side-bar > ul > li {
        list-style: none;
        padding-bottom: 16px;
    }

    #side-bar > ul > li > a{
        text-decoration: none;
        color: black;
    }
    .side-bar-title{
        font-size: 16px;
        font-weight: bold;
        margin: 1rem 0 0 1rem;
    }
    .card-img-top {
        width: 100%;
        object-fit: contain;
        align-self: center;
        height: 20vh;
}
</style>