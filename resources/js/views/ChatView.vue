<template>
    <div class="wrapper py-4">
        <transition name="fade" mode="out-in"> 
            <div v-if="!isChatSelected" id="chat-bar" class="main-content" key="selectWindow">
                <h3 class="chat-bar-title">Messages</h3>
                
                <div class="selector-group" role="group">
                  <button type="button" class="" @click="displayUserDibs = true" v-bind:class="{active: displayUserDibs}">Your Dibs</button>
                  <button type="button" class="" @click="displayUserDibs = false" v-bind:class="{active: !displayUserDibs}">Your Items</button>
                </div>
            	
            	<template v-if="items">
                    <ul v-if="filteredChats.length" style="width: 100%;">
                        <li v-for="item in filteredChats" @click="activeItem = item" :key="item.id">
                            <a href="#">
                                <div style="height:80px; display: flex; box-shadow: 0 1px 3px 0 rgba(30,41,61,.1), 0 1px 2px 0 rgba(30,41,61,.2);">
                                    <div class="item-chat-thumbnail"><img style="max-width:100%; max-height: 100%;" :src="'/uploads/' + item.imageurl"></div>
                                    <div style="align-self: center;     margin-left: 10px;">
                                        <h4 v-if="item.dibscaller.id === user.id">
                                        {{item.owner.name}}
                                        </h4>
                                        <h4 v-else>{{item.dibscaller.name}}</h4>
                                        <h5>Item: {{item.name}}</h5>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div v-else class="alert alert-warning" role="alert">No items were found!</div>
                </template>
                
            </div>
            <div v-else class="main-content" key="messageWindow">
                <div class="chat-header">
                    <a href="#" class="back-button" @click="activeItem = null">
                        <img src="svg/return-1.svg">
                        <span>Chats</span>
                    </a>
                    <a href="#" class="refresh-button" @click="fetchMessages">
                        <img src="svg/refresh.svg">
                    </a>
                </div>
                <section v-if="activeItem" class="active-item-container">
                    <div class="active-item-thumbnail">
                        <img style="max-width:100%; max-height: 100%;" :src="'/uploads/' + activeItem.imageurl">
                    </div>
                    <div style="padding: 18px;box-sizing: inherit; flex: 1 1 auto; ">
                        <h5 class="">{{activeItem.name}}</h5>
                        <p class="">{{ activeItem.description }}</p>
                    </div>
                </section>
                <template v-for="message in allMessages">
                    <div v-if="message.user_id == user.id" style="align-self: flex-start; padding: 1rem;">
                        <p style="font-weight:bold; margin-bottom: 10px;">You sent: </p>
                        <p>{{message.message}}</p>  
                    </div>
                    <div v-else style="align-self: flex-end;  padding: 1rem;">
                        <p style="font-weight:bold; text-align: right; margin-bottom: 10px;">{{message.user.name}} sent:</p>
                        <p>{{message.message}}</p>  
                    </div>
                </template>
                <div class="input-box">
                    <form enctype="multipart/form-data" @submit.prevent="sendMessage">
                        <div class="input-group mb-3">
                          <input type="text" v-model="message" class="form-control" placeholder="Your message here..." aria-label="Your message here..." aria-describedby="basic-addon2">
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Send</button>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
        </transition>
    </div>
    
</template>
<script>
import axios from 'axios';
export default {
    props:['user'], // loged user
    data () {
      return {
        message:null,
        activeItem:null,
        allMessages:[],
        items:[],
        displayUserDibs: true,
        selectedFilter: "displayUserDibs",
        value: 0
      }
    },
    computed:{
        isChatSelected: function(){
            return this.activeItem !== null ? true : false;
        },
        filteredChats: function(){
            let chats = this.items;
            if(this.selectedFilter == "displayUserDibs")
                chats = chats.filter((chat) => {
                    return chat.owner_id != this.user.id
                })
            else if (this.selectedFilter == "displayUserItems")
                chats = chats.filter((chat) => {
                    return chat.owner_id == this.user.id
                })
        
        return chats;
      }
    },
    methods:{
        fetchAllChats() { // Function that will load the items on the left, each item has its message box
            axios.get('/get-chats')
            .then(response => {
                this.items = response.data;
                console.log(response.data);
            });
        },
        fetchMessages(){
            axios.get('/private-messages/' + this.activeItem.id)
                .then(response => {
                    this.allMessages = response.data;
                });
        },
        sendMessage(e){
            //check if there message
            if(!this.message){
              return alert('Please enter message');
            }
            if(!this.activeItem){
              return alert('Please select a chat');
            }
            
            
            let item_dibs_caller_id = this.activeItem.dibs_caller_id;
            let item_owner_id = this.activeItem.owner_id;
            let item_id = this.activeItem.id;

            console.log("item_dibs_caller_id: ", item_dibs_caller_id);
            console.log("item_owner_id: ", item_owner_id);
            console.log("item_id: ", item_id);
            console.log("message: ", this.message);
            
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
            
            let formData = new FormData();
            formData.append('message', this.message);
            formData.append('item_id', item_id);
            formData.append('item_owner_id', item_owner_id);
            formData.append('item_dibs_caller_id', item_dibs_caller_id);

            axios.post('/send-message', formData, config)
            .then(response => {
                    this.message=null;
                    this.allMessages.push(response.data.message)
            });
        }
    },
    mounted(){
        this.fetchAllChats();
    },
    watch:{
        activeItem: function(){
            if (this.activeItem){
                this.fetchMessages();
            }
        },
        displayUserDibs: function(){
            if (this.displayUserDibs)
                this.selectedFilter = "displayUserDibs";
            else
                this.selectedFilter = "displayUserItems";
        }
    }
}
</script>

<style scoped>

.selector-group{
    position: relative;
    display: inline-flex;
    vertical-align: middle;
    padding: 1rem;
}
.selector-group > button {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
    background-color: transparent;
    color: #2d3b45;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 0.9rem;
    line-height: 1.6;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.selector-group > .active{
    color: white;
    background-color: #8b969e;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity .3s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.wrapper {
    display: flex;
    width: 100%;
    align-items: stretch;
}
.chat-header{
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 60px;
    box-sizing: border-box;
}

.back-button{
    display: flex;
    align-items: center;
    text-decoration: none;
    box-sizing: border-box;
    padding: 10px 0 10px 0;
    height: 100%;
}
.back-button > span{
    font-size: 1.6rem;
    color: #2d3b45;
}
.back-button > img{
    height: 100%;
    padding: 5px 0px 5px 0;
    
}
.refresh-button{
    height: 100%;
    padding: 10px 0 10px 0;
}
.refresh-button > img{
    height: 100%;
    padding: 0 10px 0 0;
}
    
.main-content{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    box-shadow: 0 2px 4px 0 rgba(0,0,0,.1);
}
.input-box{
    padding: 1rem;
    width: 100%;
}
.item-chat-thumbnail{
    height: 80px;
    width: 80px;
    flex: 0 0 auto;
    display: flex;
    padding: 5px;
    flex-direction: column;
    justify-content: space-around;
}
.item-chat-thumbnail > img{
    object-fit: contain;  
}
.active-item-thumbnail{
    height: 140px;
    width: 200px;
    flex: 0 0 auto;
    display: flex;
    padding: 0.5rem;
    flex-direction: column;
    justify-content: space-around;
}
.active-item-thumbnail > img{
    object-fit: contain;  
}
.active-item-container{
    display: flex;
    border-radius: 3px;
    background-color: #fff;
    box-shadow: 0 1px 3px 0 rgba(30,41,61,.1), 0 1px 2px 0 rgba(30,41,61,.2); 
    width: 100%;
}


#chat-bar{
    box-shadow: 0 2px 4px 0 rgba(0,0,0,.1);
}

#chat-bar > ul {
    display: block;
    padding: 16px;
    list-style-type: none;
}
#chat-bar > ul > li {
    list-style: none;
    padding-bottom: 16px;
}

#chat-bar> ul > li > a{
    text-decoration: none;
    color: black;
}
.chat-bar-title{
    font-weight: bold;
}


</style>