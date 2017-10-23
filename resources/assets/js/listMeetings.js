
require('./bootstrap');

window.Vue = require('vue');



import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';

window.toastr = toastr;


import MeetingsTable from './components/meetings/MeetingsTable';


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
      header: 'الهيدر',
    	resource_url: '/meetings/list',
      start: '',
      end: ''
    },
    components: {
      MeetingsTable
    },
   	methods: {
      fetchData(){
        axios.get(this.resource_url)
          .then(response => this.assignData(response));
      },
      assignData(response){
        this.thisweekcevil = response.data.thisWeekCevil;
        this.thisweekcriminal = response.data.thisWeekCriminal;
        this.nextweekcevil = response.data.nextWeekCevil;
        this.nextweekcriminal = response.data.nextWeekCriminal;
        this.cevil = response.data.cevil;
        this.criminal = response.data.criminal;
      }
    },
    created() {
      this.fetchData();
      eventBus.$on('refetchData', event => this.fetchData());
    }
});


toastr.options = {
  "positionClass": "toast-bottom-right",
}