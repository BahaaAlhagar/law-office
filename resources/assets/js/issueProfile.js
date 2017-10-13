require('./bootstrap');

window.Vue = require('vue');

// import editIssue from './components/issue/editIssue.vue';
import issueInfo from './components/issue/issueInfo.vue';


window.eventBus = new Vue();

const issueProfile = new Vue({
	    el: '#issueProfile',
	    data: {
	    	issue: [],
	    	people: []
	    	},
	    methods: {
	      fetchIssueInfo(){
	    	axios.get(window.location.pathname)
	    		.then(response => this.assignData(response));
	      },
	      assignData(response){
	      	this.issue = response.data.issue;
	      	this.people = response.data.issue.people;
	      }
	    },
	    components: {
	    	issueInfo
	    },
	    created(){
	    	this.fetchIssueInfo();
	    }
    });
