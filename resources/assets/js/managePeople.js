
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueResource from 'vue-resource';
import VuePaginator from 'vuejs-paginator';

Vue.use(VueResource);

import addPerson from './components/person/addPerson.vue';
import editPerson from './components/person/editPerson.vue';

window.eventBus = new Vue();

const managePeople = new Vue({
    el: '#managePeople',
    data: {
    	people: [],
    	person: [],
    	current_view: '',
    	resource_url: '',
    	options: {
              remote_data: 'people.data',
              remote_current_page: 'people.current_page',
              remote_last_page: 'people.last_page',
              remote_next_page_url: 'people.next_page_url',
              remote_prev_page_url: 'people.prev_page_url',
              next_button_text: 'التالى',
              previous_button_text: 'السابق'
            },
    },
   	methods: {
   		updateResource(data){
  			this.people = data;
  		}
   	},
    components: {
    	addPerson,
    	editPerson,
    	VPaginator: VuePaginator
    },
    created() {
    	axios.get('/people')
   		.then(response => this.people = response.data.people.data);
    }

});
