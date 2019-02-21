<template>
<div class="input-group">
    <div class="input-group-prepend">
        <select :value="selectedCategoryID" @input="$emit('update:selectedCategoryID', $event.target.value)" class="form-control">
            <option v-for="item in categories" v-bind:value="item.id">
            {{item.name}}
            </option>
        </select>
    </div>
    <input type="text" class="form-control" :value="searchText" @input="$emit('update:searchText', $event.target.value)">
</div>
</template>

<script>
export default {
    props: ['categories','selectedCategoryID','searchText'],
    }
    
</script>

