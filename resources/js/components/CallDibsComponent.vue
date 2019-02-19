<template>
    <div v-if="user == null" class="alert alert-warning">
        Login or Register to call Dibs!
    </div>
    <div v-else>
        <div v-if="selectedItem.owner_id == user.id" class="alert alert-warning">You can't call dibs in your own items</div>
        <div v-else>
            <div v-if="selectedItem.dibs_caller_id == null">
                <button class="btn btn-primary" v-on:click="callDibs">Call Dibs</button>
            </div>
            <div v-else>
                <template v-if="selectedItem.dibs_caller_id == user.id">
                <div class="alert alert-success">Dibs called by you</div>
                <button class="btn btn-danger" v-on:click="cancelDibs">Cancel Dibs</button>
                </template>
                <div v-else class="alert alert-warning">Dibs called by other user</div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    props: ['user','selectedItem'],
    methods: {
        callDibs(){
            axios.post('/call-dibs/' + this.selectedItem.id)
            .then(response => {
                alert(response.data.message);
                this.$emit('calledDibs',this.selectedItem.id);
            });
        },
        cancelDibs(){
            axios.post('/cancel-dibs/' + this.selectedItem.id)
            .then(response => {
                alert(response.data.message);
                this.$emit('calledDibs',this.selectedItem.id);
            });
        }
    }
}

</script>