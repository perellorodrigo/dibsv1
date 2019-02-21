
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'

require('./bootstrap');

window.Vue = require('vue');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

Vue.component('browse-view', require('./views/BrowseView.vue').default);
Vue.component('manage-items-view', require('./views/ManageItemsView.vue').default);
Vue.component('chat-view', require('./views/ChatView.vue').default);


Vue.component('item-component', require('./components/ItemComponent.vue').default);
Vue.component('google-map-component', require('./components/GoogleMapComponent.vue').default);
Vue.component('modal-component', require('./components/ModalComponent.vue').default);
Vue.component('search-bar-component', require('./components/SearchBarComponent.vue').default);
Vue.component('radius-slider-component', require('./components/RadiusSliderComponent.vue').default);
Vue.component('add-item-component', require('./components/AddItemComponent.vue').default);
Vue.component('call-dibs', require('./components/CallDibsComponent.vue').default);





/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 * 
Vue.component('item-component', require('./components/ItemComponent.vue'));
Vue.component('page', require('./components/Page.vue'));
 */


const app = new Vue({
    el: '#app',
}
);
