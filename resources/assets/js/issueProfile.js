require('./bootstrap');

window.Vue = require('vue');

import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
window.toastr = require('toastr');
import bootstrap from 'bootstrap';

import issueInfo from './components/issue/issueInfo.vue';
import issueOpenents from './components/issue/issueOpenents.vue';


window.eventBus = new Vue();

const issueProfile = new Vue({
	    el: '#issueProfile',
	    data: {
	    	issue: {},
	    	openents: [],
	    	people: []
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
	      }
	    },
	    components: {
	    	issueInfo,
	    	issueOpenents
	    },
	    created(){
	    	this.fetchIssueInfo();

	    	eventBus.$on('refetchIssueInfo', event => this.fetchIssueInfo());
	    }
    });

toastr.options = {
  "positionClass": "toast-bottom-right",
}