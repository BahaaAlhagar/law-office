
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueResource from 'vue-resource';
import VuePaginator from 'vuejs-paginator';

Vue.use(VueResource);


import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';

window.select2 = require('select2');

import addContract from './components/contract/addContract.vue';
import editContract from './components/contract/editContract.vue';

window.eventBus = new Vue();

const manageContracts = new Vue({
    el: '#manageContracts',
    data: {
    	contracts: [],
      people: [],
    	current_view: 'all',
    	resource_url: '/contracts',
    	options: {
              remote_data: 'contracts.data',
              remote_current_page: 'contracts.current_page',
              remote_last_page: 'contracts.last_page',
              remote_next_page_url: 'contracts.next_page_url',
              remote_prev_page_url: 'contracts.prev_page_url',
              next_button_text: 'التالى',
              previous_button_text: 'السابق'
            },
    },
   	methods: {
   		updateResource(data){
  			this.contracts = data;
  		},
      afterContractAdded(response){
        this.contracts.unshift(response.item);
        $('#addContract').modal('hide');
        toastr.success(response.message);
      },
      editContract(contract){
        eventBus.$emit('editContract', contract);
        $('#editContract').modal('show');
      },
      afterContractUpdated(response){
        $('#editContract').modal('hide');
        toastr.info(response.message);
        this.reloadData();
      },
      deleteContract(contract){
        if(confirm('هل انت متاكد من حذف هذا التوكيل')){
        axios.delete('/contracts/' + contract.id)
        .then(response => this.onContractDelete(response));
      }
      },
      onContractDelete(response){
        this.reloadData();
        toastr.warning(response.data.message);
      },
      fetchContractsData(){
        if(this.current_view == 'all'){
          axios.get('/contracts')
          .then(response => this.assignData(response));
          this.resource_url = '/contracts';
        }
        if(this.current_view == '1'){
          axios.get('/contract/1')
          .then(response => this.assignData(response));
          this.resource_url = '/contract/1';
        }
        if(this.current_view == '2'){
          axios.get('/contract/2')
          .then(response => this.assignData(response));
          this.resource_url = '/contract/2';
        }
        if(this.current_view == '3'){
          axios.get('/contract/3')
          .then(response => this.assignData(response));
          this.resource_url = '/contract/3';
        }
        if(this.current_view == 'trashed'){
          axios.get('/contract/trashed')
          .then(response => this.contracts = response.data.contracts.data);
          this.resource_url = '/contract/trashed';
        }
      },
      assignData(response){
          this.contracts = response.data.contracts.data;
          this.people = response.data.people;
      },
      reloadData(){
          this.$refs.VP.fetchData(this.resource_url + '?page=' + this.$refs.VP.current_page);
      },
      restore(contract){
        axios.get('/contracts/' + contract.id + '/restore')
          .then(response => this.contractRestored(response));
      },
      contractRestored(response){
        this.reloadData();
        toastr.success(response.data.message);
      },
      printTable(){
        $('.print-hidden').hide()
        $('.btn').hide()
        window.print()
        $('.print-hidden').show()
        $('.btn').show()
      }
   	},
    components: {
    	addContract,
    	editContract,
    	VPaginator: VuePaginator
    },
    created() {
      this.fetchContractsData();

      eventBus.$on('contractAdded', response => this.afterContractAdded(response));
      
      eventBus.$on('contractUpdated', response => this.afterContractUpdated(response));
    }

});


toastr.options = {
  "positionClass": "toast-bottom-right",
}