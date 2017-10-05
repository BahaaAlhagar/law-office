require('./bootstrap');

window.Vue = require('vue');

import editPerson from './components/person/editPerson.vue';
import Contracts from './components/person/contracts.vue';

import Form from './partials/Form';
window.Form = Form;

import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';

window.eventBus = new Vue();

const personProfile = new Vue({
	    el: '#personProfile',
	    data: {
	    	person: [],
	    	contracts: []
	    	},
	    methods: {
	      assignData(response){
	      	this.person = response.data.person;
	      	this.contracts = response.data.person.contracts;
	      },
	      editPerson(person){
	        eventBus.$emit('editPerson', person);
	        $('#editPerson').modal('show');
	      },
	      afterPersonUpdated(response){
	        $('#editPerson').modal('hide');
	        toastr.info(response.message);
	        this.person = response.item;
	      },
	      deletePerson(person){
		    if(confirm('هل انت متاكد من حذف هذا الشخص')){
	        axios.delete('/people/' + person.id)
	        .then(response => this.onPersonDelete(response));
			   }
		  },
	      onPersonDelete(response){
	        toastr.warning(response.data.message);
	        window.location.replace('/people/');
	      }
	    },
	    components: {
	    	editPerson,
	    	Contracts
	    },
	    created(){
	    	axios.get(window.location.pathname)
	    	.then(response => this.assignData(response));

	    	eventBus.$on('personUpdated', response => this.afterPersonUpdated(response));
	    }
    });


toastr.options = {
  "positionClass": "toast-bottom-right",
}