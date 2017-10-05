require('./bootstrap');

window.Vue = require('vue');

import editContract from './components/contract/editContract.vue';


import Form from './partials/Form';
window.Form = Form;

import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';

window.eventBus = new Vue();

const contractProfile = new Vue({
	    el: '#contractProfile',
	    data: {
	    	contract: [],
	    	people: []
	    	},
	    methods: {
	      assignData(response){
	      	this.contract = response.data.contract;
	      	this.people = response.data.people;
	      },
	      editContract(contract){
	        eventBus.$emit('editContract', contract);
	        $('#editContract').modal('show');
	      },
	      afterContractUpdated(response){
	        $('#editContract').modal('hide');
	        toastr.info(response.message);
	        this.contract = response.item;
	      },
	      deleteContract(contract){
		    if(confirm('هل انت متاكد من حذف هذا التوطيل')){
	        axios.delete('/contracts/' + contract.id)
	        .then(response => this.onContractDelete(response));
			   }
		  },
	      onContractDelete(response){
	        toastr.warning(response.data.message);
	        window.location.replace('/contracts/');
	      }
	    },
	    components: {
	    	editContract,
	    },
	    created(){
	    	axios.get(window.location.pathname)
	    	.then(response => this.assignData(response));

	    	eventBus.$on('contractUpdated', response => this.afterContractUpdated(response));
	    }
    });

toastr.options = {
  "positionClass": "toast-bottom-right",
}