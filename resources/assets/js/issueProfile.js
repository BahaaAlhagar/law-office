require('./bootstrap');

window.Vue = require('vue');

import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
window.toastr = require('toastr');
import bootstrap from 'bootstrap';

import issueInfo from './components/issue/issueInfo';
import issueOpenents from './components/issue/issueOpenents';
import issueFiles from './components/issue/files/issueFiles';
import issueMeetings from './components/issue/meetings/issueMeetings';


window.eventBus = new Vue();

const issueProfile = new Vue({
	    el: '#issueProfile',
	    data: {
	    	issue: {},
	    	openents: [],
	    	people: [],
	    	files: []
	    	},
	    methods: {
	      fetchIssueInfo(){
	    	axios.get(window.location.pathname)
	    		.then(response => this.assignData(response));
	      },
	      assignData(response){
	      	this.issue = response.data.issue;
	      	this.openents = response.data.issue.openents;
	      	this.people = response.data.people;
	      },
	      fetchIssueFiles(){
	      	axios.get(window.location.pathname + '/files')
	    		.then(response => this.assignFilesData(response));
	      },
	      assignFilesData(response){
      		this.issue = response.data.issue;
      		this.files = response.data.files;
	      }
	    },
	    components: {
	    	issueInfo,
	    	issueOpenents,
	    	issueFiles,
	    	issueMeetings
	    },
	    created(){
	    	this.fetchIssueInfo();
	    	eventBus.$on('refetchIssueInfo', event => this.fetchIssueInfo());

	    	this.fetchIssueFiles();
	    	eventBus.$on('refetchIssueFiles', event => this.fetchIssueFiles());
	    }
    });

toastr.options = {
  "positionClass": "toast-bottom-right",
}