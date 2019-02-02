<template>
<div class="row justify-content-center">
    <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div class="alert alert-success" role="alert" v-if="user">
                        Hello {{ user.name }}
                    </div>
                </div>
            </div>
    </div>
    <section class="wrapper mt-4">
        <div v-for="item in items" class="card" style="width: 100%;height:100%">
            <img :src="'/uploads/' + item.imageurl" class="card-img-top">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title mt-auto">{{item.name}}</h5>
                <p class="card-text">{{ item.description }}</p>
            </div>
        </div>
    </section>
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
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      grid-gap: 20px;
      align-items: stretch;
}
.card-img-top {
    width: 100%;
    object-fit: cover;
    align-self: center;
    height: 20vh;
}
</style>