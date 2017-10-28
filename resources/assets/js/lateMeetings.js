
require('./bootstrap');

window.Vue = require('vue');



import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';

window.toastr = toastr;


import lateMeetingsTable from './components/office/lateMeetingsTable';


window.eventBus = new Vue();

const lateMeetings = new Vue({
    el: '#lateMeetings',
    data: {
      cevil_meetings: [],
      criminal_meetings: []
    },
    methods: {
      fetchData(){
        axios.get(window.location.pathname)
          .then(response => this.assignData(response));
        },
      assignData(response){
        this.cevil_meetings = response.data.cevilMeetings;
        this.criminal_meetings = response.data.criminalMeetings;
        },
      printPage(){
          $('.print-hidden').hide();
          $('.btn').hide();
          window.print()
          $('.print-hidden').show();
          $('.btn').show(); 
        },
      afterMeetingUpdated(response){
          $('#editMeeting').modal('hide');
          toastr.info(response.message);
          this.fetchData();
        },
    },
    components: {
      lateMeetingsTable
    },
    mounted() {
      this.fetchData();
      eventBus.$on('meetingUpdated', response => this.afterMeetingUpdated(response));
    }
});


toastr.options = {
  "positionClass": "toast-bottom-right",
}