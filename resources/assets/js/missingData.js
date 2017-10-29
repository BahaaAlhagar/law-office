
require('./bootstrap');

window.Vue = require('vue');



import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';

window.toastr = toastr;


import IssueNumbersTable from './components/office/IssueNumbersTable';
import IssueAdvNumbersTable from './components/office/IssueAdvNumbersTable';
import missingRecordsTable from './components/office/missingRecordsTable';


window.eventBus = new Vue();

const missingData = new Vue({
    el: '#missingData',
    data: {
      issue_numbers: [],
      issue_adv_numbers: [],
      records: [],
    	dates: [],
      fetched: false
    },
   	methods: {
      fetchData(){
        axios.get(window.location.pathname)
          .then(response => this.assignData(response));
      },
      assignData(response){
        this.fetched = true;
        this.issue_numbers = response.data.issueNumbers;
        this.issue_adv_numbers = response.data.issueAdvNumbers;
        this.records = response.data.records;
        this.dates = response.data.dates;
      },
      printPage(){
          $('.print-hidden').hide();
          $('.btn').hide();
          window.print()
          $('.print-hidden').show();
          $('.btn').show();
      },
      dayFromat(meetingdate){
          var d = new Date(meetingdate);
          var days = ["الاحــد","الاثــنين","الثلاثــاء","الاربعــاء","الخمــيس","الجمـــعة","الســبت"];
          return days[d.getDay()] + ' ' + meetingdate;
      },
      afterIssueUpdated(response){
        $('#editIssue').modal('hide');
        this.fetchData();
        toastr.info(response.message);
      }
    },
    components: {
      IssueNumbersTable,
      IssueAdvNumbersTable,
      missingRecordsTable
    },
    mounted() {
      this.fetchData();
      eventBus.$on('IssueUpdated', response => this.afterIssueUpdated(response));
      }
});


toastr.options = {
  "positionClass": "toast-bottom-right",
}