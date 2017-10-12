require('./bootstrap');

window.Vue = require('vue');

import VueResource from 'vue-resource';
import VuePaginator from 'vuejs-paginator';

Vue.use(VueResource);


 import fileUploader from './components/fileUploader.vue';
// import Contracts from './components/person/contracts.vue';

import Form from './partials/Form';
window.Form = Form;

import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';

window.eventBus = new Vue();

const personFiles = new Vue({
	    el: '#personFiles',
	    data: {
	    	person: [],
	    	files: [],
	    	resource_url: '',
	    	options: {
	              remote_data: 'files.data',
	              remote_current_page: 'files.current_page',
	              remote_last_page: 'files.last_page',
	              remote_next_page_url: 'files.next_page_url',
	              remote_prev_page_url: 'files.prev_page_url',
	              next_button_text: 'التالى',
	              previous_button_text: 'السابق'
	            },
	    	},
	    methods: {
	      fetchFiles(){
	      	axios.get(window.location.pathname)
	    		.then(response => this.assignData(response));
	      },
	      assignData(response){
	      	this.person = response.data.person;
	      	this.files = response.data.files.data;
	      },
	   	  updateResource(data){
	  		this.files = data;
	  	  },
	  	  fileAdded(){
	  	  	this.fetchFiles();
	  	  	toastr.success('تم اضافة الملف بنجاح!');
	  	  },
/*	      editPerson(person){
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
	      }*/
	    },
	    components: {
	    	VPaginator: VuePaginator,
	    	'file-uploader': fileUploader
	    },
	    created(){
	    	this.fetchFiles();
	    	eventBus.$on('fileUploaded', event => this.fileAdded());
	    	// eventBus.$on('personUpdated', response => this.afterPersonUpdated(response));
	    }
    });


toastr.options = {
  "positionClass": "toast-bottom-right",
}