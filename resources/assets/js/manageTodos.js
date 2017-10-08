
require('./bootstrap');

window.Vue = require('vue');

import VueResource from 'vue-resource';
import VuePaginator from 'vuejs-paginator';

Vue.use(VueResource);

import addTodo from './components/todo/addTodo.vue';
import editTodo from './components/todo/editTodo.vue';



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
      afterTodoAdded(response){
        this.reloadData();
        $('#addTodo').modal('hide');
        toastr.success(response.message);
      },
      editTodo(todo){
        eventBus.$emit('editTodo', todo);
        $('#editTodo').modal('show');
      },
      afterTodoUpdated(response){
        $('#editTodo').modal('hide');
        toastr.info(response.message);
        this.reloadData();
      },
      deleteTodo(todo){
        if(confirm('هل انت متاكد من حذف هذا العمل الادارى - لن تستطيع استرجاعه ثانيا')){
        axios.delete('/todos/' + todo.id)
        .then(response => this.onTodoDelete(response));
        }
      },
      onTodoDelete(response){
        this.reloadData();
        toastr.warning(response.data.message);
      },
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
    	editTodo,
    	VPaginator: VuePaginator
    },
    created() {
      this.fetchTodosData();

      eventBus.$on('todoAdded', response => this.afterTodoAdded(response));
      
      eventBus.$on('todoUpdated', response => this.afterTodoUpdated(response));
    }

});


toastr.options = {
  "positionClass": "toast-bottom-right",
}