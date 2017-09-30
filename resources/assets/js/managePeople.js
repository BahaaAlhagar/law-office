
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


import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';





window.eventBus = new Vue();

const managePeople = new Vue({
    el: '#managePeople',
    data: {
    	people: [],
    	current_view: 'all',
    	resource_url: '/people',
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
  		},
      afterPersonAdded(response){
        this.people.unshift(response.item);
        $('#addPerson').modal('hide');
        toastr.success(response.message);
      },
      editPerson(person){
        eventBus.$emit('editPerson', person);
        $('#editPerson').modal('show');
      },
      afterPersonUpdated(response){
        $('#editPerson').modal('hide');
        toastr.info(response.message);
        this.reloadData();
      },
      deletePerson(person){
        if(confirm('هل انت متاكد من حذف هذا الشخص')){
        axios.delete('/people/' + person.id)
        .then(response => this.onPersonDelete(response));
      }
    },
      onPersonDelete(response){
        this.reloadData();
        toastr.warning(response.data.message);
      },
      fetchPPLData(){
        if(this.current_view == 'all'){
          axios.get('/people')
          .then(response => this.people = response.data.people.data);
          this.resource_url = '/people';
        }
        if(this.current_view == 'clients'){
          axios.get('/filtered-ppl/clients')
          .then(response => this.people = response.data.people.data);
          this.resource_url = '/filtered-ppl/clients';
        }
        if(this.current_view == 'notClients'){
          axios.get('/filtered-ppl/notclients')
          .then(response => this.people = response.data.people.data);
          this.resource_url = '/filtered-ppl/notclients';
        }
        if(this.current_view == 'trashed'){
          axios.get('/filtered-ppl/trashed')
          .then(response => this.people = response.data.people.data);
          this.resource_url = '/filtered-ppl/trashed';
        }
      },
      reloadData(){
        this.$refs.VP.fetchData(this.resource_url + '?page=' + this.$refs.VP.current_page);
      },
      restore(person){
        axios.get('/people/' + person.id + '/restore')
          .then(response => this.personRestored(response));
      },
      personRestored(response){
        this.reloadData();
        toastr.success(response.data.message);
      },
      printTable(){
        $('.print-hidden').hide()
        $('.btn').hide()
        window.print()
        $('.print-hidden').show()
        $('.btn').show()
      }
   	},
    components: {
    	addPerson,
    	editPerson,
    	VPaginator: VuePaginator
    },
    created() {
      this.fetchPPLData();

      eventBus.$on('personAdded', response => this.afterPersonAdded(response));
      
      eventBus.$on('personUpdated', response => this.afterPersonUpdated(response));
    }

});


toastr.options = {
  "positionClass": "toast-bottom-right",
}