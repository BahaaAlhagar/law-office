
require('./bootstrap');

window.Vue = require('vue');

import VueResource from 'vue-resource';
import VuePaginator from 'vuejs-paginator';

Vue.use(VueResource);

import addTodo from './components/todo/addTodo.vue';
import editPerson from './components/person/editPerson.vue';


import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';





window.eventBus = new Vue();

const manageTodos = new Vue({
    el: '#manageTodos',
    data: {
    	todos: [],
    	current_view: '0',
    	resource_url: '/todo/0',
    	options: {
              remote_data: 'todos.data',
              remote_current_page: 'todos.current_page',
              remote_last_page: 'todos.last_page',
              remote_next_page_url: 'todos.next_page_url',
              remote_prev_page_url: 'todos.prev_page_url',
              next_button_text: 'التالى',
              previous_button_text: 'السابق'
            },
    },
   	methods: {
   		updateResource(data){
  			this.todos = data;
  		},
/*      afterPersonAdded(response){
        this.todos.unshift(response.item);
        $('#addPerson').modal('hide');
        toastr.success(response.message);
      },
      editPerson(person){
        eventBus.$emit('editPerson', person);
        $('#editPerson').modal('show');
      },
      afterPersonUpdated(response){
        $('#editPerson').modal('hide');
        toastr.info(response.message);
        this.reloadData();
      },
      deletePerson(person){
        if(confirm('هل انت متاكد من حذف هذا الشخص')){
        axios.delete('/todos/' + person.id)
        .then(response => this.onPersonDelete(response));
        }
      },
      onPersonDelete(response){
        this.reloadData();
        toastr.warning(response.data.message);
      },*/
      fetchTodosData(){
        axios.get('/todo/' + this.current_view)
        .then(response => this.todos = response.data.todos.data);
        this.resource_url = '/todo/' + this.current_view;
      },
      reloadData(){
        this.$refs.VP.fetchData(this.resource_url + '?page=' + this.$refs.VP.current_page);
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
    	addTodo,
    	editPerson,
    	VPaginator: VuePaginator
    },
    created() {
      this.fetchTodosData();

      eventBus.$on('personAdded', response => this.afterPersonAdded(response));
      
      eventBus.$on('personUpdated', response => this.afterPersonUpdated(response));
    }

});


toastr.options = {
  "positionClass": "toast-bottom-right",
}