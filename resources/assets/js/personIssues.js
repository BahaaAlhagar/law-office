
require('./bootstrap');

window.Vue = require('vue');



import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';

window.toastr = toastr;


import IssuesTable from './components/person/IssuesTable';
import excutiveIssueTable from './components/person/excutiveIssueTable';


window.eventBus = new Vue();

const personIssues = new Vue({
    el: '#personIssues',
    data: {
      cevil_issues: [],
      criminal_issues: [],
      excutive_issues: [],
      records: []
    },
    methods: {
      fetchData(){
        axios.get(window.location.pathname)
          .then(response => this.assignData(response));
        },
      assignData(response){
        this.cevil_issues = response.data.cevilIssues;
        this.criminal_issues = response.data.criminalIssues;
        this.excutive_issues = response.data.excutiveIssues;
        this.records = response.data.records;
        },
      printPage(){
          $('.print-hidden').hide();
          $('.btn').hide();
          $('.heading').hide();
          window.print()
          $('.print-hidden').show();
          $('.btn').show();
          $('.heading').show();
        }
    },
    components: {
      IssuesTable,
      excutiveIssueTable
    },
    created() {
      this.fetchData();
      eventBus.$on('refetchData', event => this.fetchData());
    }
});


toastr.options = {
  "positionClass": "toast-bottom-right",
}