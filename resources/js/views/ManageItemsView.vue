<template>
    <div class="wrapper">
        <div id="side-bar">
            <p class="side-bar-title">Manage Items</p>
            <ul>
                <li><a href="#">Available</a></li>
                <li><a href="#">Awaiting Pick-up</a></li>
                <li><a href="#">History</a></li>
            </ul>
        </div>
        <div class="main-content">
            <div class="col-md-8">
                    <div class="card card-default">
                        <div class="card-header">Manage Items</div>
        
                        <div class="card-body">
                            <div class="alert alert-warning" role="alert">
                                No items available
                            </div>
                        </div>
                    </div>
            </div>
            <section class="item-section mt-4">
                <template v-if="items" v-for="item in items">
                    <item-component  :item="item" :key="item.id" ></item-component>
                </template>
            </section>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
    export default {
        props: ['user'],
        data() {
            return {
                items: null
            };
        },
        mounted() {
            console.log('Component mounted.')
            console.log(this.user.id)
            axios.get('/api/dibbeditems/' + this.user.id)
            .then(response => {
                this.items = response.data.data;
                console.log('items mounted.')
                console.dir(this.items)
            })
        }
    }
</script>
<style scoped>
    .wrapper{
        display: grid;
        grid-template-columns: 230px auto;
        
    }
    .main-content{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        
    }
    .item-section{
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        grid-gap: 20px;
        align-items: stretch;
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
</style>