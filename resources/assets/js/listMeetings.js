
require('./bootstrap');

window.Vue = require('vue');



import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';

window.toastr = toastr;


import MeetingsTable from './components/meetings/MeetingsTable';
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
const Arabic = require("flatpickr/dist/l10n/ar.js").ar;

window.eventBus = new Vue();

const listMeetings = new Vue({
    el: '#listMeetings',
    data: {
      thisweekcevil: [],
      thisweekcriminal: [],
      nextweekcevil: [],
    	nextweekcriminal: [],
      cevil: [],
      criminal: [],
    	resource_url: '/meetings/list',
      showDefault: true,
      start: '',
      end: '',
      printed_start: '',
      printed_end: '',
      config: {locale: Arabic},
      fetched: false
    },
    components: {
      MeetingsTable,
      flatPickr
    },
   	methods: {
      fetchData(){
        axios.get(this.resource_url)
          .then(response => this.assignData(response));
      },
      afterMeetingUpdated(response){
        $('#editMeeting').modal('hide');
        toastr.info(response.message);
        this.fetchData();
      },
      assignData(response){
        this.thisweekcevil = response.data.thisWeekCevil;
        this.thisweekcriminal = response.data.thisWeekCriminal;
        this.nextweekcevil = response.data.nextWeekCevil;
        this.nextweekcriminal = response.data.nextWeekCriminal;
        this.fetched = true;
        if(!this.showDefault){
        this.cevil = response.data.cevil;
        this.criminal = response.data.criminal;
        }
      },
      printPage(){
          $('.print-hidden').hide();
          $('.btn').hide();
          $('.heading').hide();
          window.print()
          $('.print-hidden').show();
          $('.btn').show();
          $('.heading').show();
      },
      listDates(){
        if(this.start && this.end){
          this.fetched = false;
          this.resource_url = '/meetings/list/' + this.start + '/' + this.end;
          this.showDefault = false;
          this.printed_start = this.start;
          this.printed_end = this.end;
          this.fetchData();
        }
      },
      dayFromat(meetingdate){
          var d = new Date(meetingdate);
          var days = ["الاحــد","الاثــنين","الثلاثــاء","الاربعــاء","الخمــيس","الجمـــعة","الســبت"];
          return days[d.getDay()] + ' ' + meetingdate;
      },
      echoDatesRange(){
        if(this.printed_start !== this.printed_end){
          return 'من ' + this.dayFromat(this.printed_start) + ' حتى ' + this.dayFromat(this.printed_end);
        } else {
          return 'ليوم ' + this.dayFromat(this.printed_start);
        }
      }
    },
    mounted() {
      this.fetchData();
      eventBus.$on('meetingUpdated', response => this.afterMeetingUpdated(response));
    }
});


toastr.options = {
  "positionClass": "toast-bottom-right",
}