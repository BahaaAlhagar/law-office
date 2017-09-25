
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueResource from 'vue-resource';
import VuePaginator from 'vuejs-paginator';

import Form from './partials/Form';

import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';




window.Form = Form;

Vue.use(VueResource);




const managePeople = new Vue({
    el: '#managePeople',
    created: function() {
    	console.log('mounted');
    }
});
