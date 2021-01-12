require('./bootstrap');

window.Vue = require('vue');

import VueResource from 'vue-resource';
import VuePaginator from 'vuejs-paginator';

Vue.use(VueResource);


import fileUploader from './components/files/fileUploader.vue';
import editFile from './components/files/editFile.vue';


import Form from './partials/Form';
window.Form = Form;

window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');

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
	  	  	this.reloadData();
	  	  	toastr.success('تم اضافة الملف بنجاح!');
	  	  },
	      editFile(file){
	        eventBus.$emit('editFile', file);
	        $('#editFile').modal('show');
	      },
	      afterFileUpdated(response){
	        $('#editFile').modal('hide');
	        toastr.info(response.message);
	        this.reloadData();
	      },
		  reloadData(){
	        this.$refs.VP.fetchData(this.resource_url + '?page=' + this.$refs.VP.current_page);
	      },
	      deleteFile(file){
	    	if(confirm('هل انت متاكد من حذف هذا الملف - لن تتمكن من استرجاعه فيما بعد!')){
        	axios.delete('/files/' + file.id)
        	.then(response => this.onFileDelete(response));
		   }
		  },
	      onFileDelete(response){
	        toastr.warning(response.data.message);
	        this.reloadData();
	      }
	    },
	    components: {
	    	VPaginator: VuePaginator,
	    	'file-uploader': fileUploader,
	    	'edit-file': editFile
	    },
	    created(){
	    	this.fetchFiles();
	    	eventBus.$on('fileUploaded', event => this.fileAdded());
	    	eventBus.$on('fileUpdated', response => this.afterFileUpdated(response));
	    }
    });


toastr.options = {
  "positionClass": "toast-bottom-right",
}