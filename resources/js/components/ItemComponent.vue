<template>
    <div class="card">
        <img :src="'/uploads/' + item.imageurl" class="card-img-top">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title mt-auto">{{item.name}}</h5>
            <p class="card-text">{{ item.description }}</p>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['item'],
        mounted() {
            console.log('Item mounted.')
        }
    }
</script>
<style scoped>
.card-img-top {
    width: 100%;
    object-fit: contain;
    align-self: center;
    height: 20vh;
}
</style>
