require('./bootstrap');

window.Vue = require('vue');

// import editIssue from './components/issue/editIssue.vue';
// import issueInfo from './components/issue/issueInfo.vue';


window.eventBus = new Vue();

const issueProfile = new Vue({
	    el: '#issueProfile',
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
	    	issueInfo
	    },
	    created(){
	    	axios.get(window.location.pathname)
	    	.then(response => this.assignData(response));

	    	eventBus.$on('personUpdated', response => this.afterPersonUpdated(response));
	    }
    });
