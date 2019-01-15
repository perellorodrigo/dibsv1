<template>
<div class="input-group">
    <div class="input-group-prepend">
        <select :value="selectedCategoryID" @input="$emit('update:selectedCategoryID', $event.target.value)">
            <option v-for="item in categories" v-bind:value="item.id">
            {{item.name}}
            </option>
        </select>
    </div>
    <input type="text" class="form-control" aria-label="Text input with dropdown button" :value="searchText" @input="$emit('update:searchText', $event.target.value)">
</div>
</template>

<script>
export default {
    props: ['categories','selectedCategoryID','searchText'],
        mounted() {
            console.log('Search Bar mounted. Categories:');
            console.dir(this.categories);
        }
    }
    
</script>

