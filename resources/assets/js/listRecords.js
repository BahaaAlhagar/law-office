
require('./bootstrap');

window.Vue = require('vue');



import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';

window.toastr = toastr;


import recordsTable from './components/office/recordsTable';


window.eventBus = new Vue();

const listRecords = new Vue({
    el: '#listRecords',
    data: {
      current_view: 1,
      records: [],
      advanced_records: []
    },
    methods: {
      fetchData(){
        axios.get(window.location.pathname)
          .then(response => this.assignData(response));
        },
      assignData(response){
        this.records = response.data.records;
        this.advanced_records = response.data.advancedRecords;
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
      recordsTable
    },
    created() {
      this.fetchData();
    }
});


toastr.options = {
  "positionClass": "toast-bottom-right",
}