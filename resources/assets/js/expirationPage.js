
require('./bootstrap');

window.Vue = require('vue');



import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';

window.toastr = toastr;


import NotPresentTable from './components/office/NotPresentTable';
import CevilJudgementsTable from './components/office/CevilJudgementsTable';
import missingRecordsTable from './components/office/missingRecordsTable';


window.eventBus = new Vue();

const expirationPage = new Vue({
    el: '#expirationPage',
    data: {
      not_present_judgements: [],
      first_judgements: [],
      late_judgements: [],
      client_records: [],
    	openent_records: [],
      fetched: false
    },
   	methods: {
      fetchData(){
        axios.get(window.location.pathname)
          .then(response => this.assignData(response));
      },
      assignData(response){
        this.fetched = true;
        this.not_present_judgements = response.data.notPresetJudgements;
        this.first_judgements = response.data.firstJudgements;
        this.late_judgements = response.data.lateJudgements;
        this.client_records = response.data.clientRecords;
        this.openent_records = response.data.openentRecords;
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
      afterJudgementUpdated(response){
        $('#addAnnouncement').modal('hide');
        this.fetchData();
        toastr.info(response.message);
      }
    },
    components: {
      NotPresentTable,
      CevilJudgementsTable,
      missingRecordsTable
    },
    mounted() {
      this.fetchData();
      eventBus.$on('judgementUpdated', response => this.afterJudgementUpdated(response));
      }
});


toastr.options = {
  "positionClass": "toast-bottom-right",
}