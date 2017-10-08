<template>
        <div class="modal fade" id="editTodo" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> تعديل عمل ادارى </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onTodoUpdate" @keydown="editForm.errors.clear($event.target.name)"
                @change="editForm.errors.clear($event.target.name)"
                @input="editForm.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="name" class="label">العمل الادارى:</label>
                        
                        <input type="text" id="name" name="name" class="form-control" v-model="editForm.name"> 

                        <span class="alert-danger" v-if="editForm.errors.has('name')" v-text="editForm.errors.get('name')"></span>
                    </div>

                    <div class="form-group">
                        <label for="date" class="label">التاريخ:</label>
                        
                        <flat-pickr v-model="editForm.date" 
                        name="date" 
                        :config="config" 
                        placeholder="اختر التاريخ">
                        </flat-pickr>

                        <span class="alert-danger" v-if="editForm.errors.has('date')" v-text="editForm.errors.get('date')"></span>
                    </div>


                    <div class="form-group">
                        <label for="notes" class="label">ملاحظات:</label>
                        
                        <input type="text" id="notes" name="notes" class="form-control" v-model="editForm.notes"> 

                        <span class="alert-danger" v-if="editForm.errors.has('notes')" v-text="editForm.errors.get('notes')"></span>
                    </div>

                    <div class="form-group">
                        <label for="completed" class="label">ملاحظات:</label>
                        
                        <select id="completed" name="completed" class="form-control" v-model.number="editForm.completed">
                            <option value="1">اكتمل</option>
                            <option value="0">غير مكتمل</option>
                        </select> 

                        <span class="alert-danger" v-if="editForm.errors.has('completed')" v-text="editForm.errors.get('completed')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="editForm.errors.any()">تعديل</button>
                    </div>
                </form>

              </div>

            </div>

          </div>

        </div>
</template>

<script>
  import flatPickr from 'vue-flatpickr-component';
  import 'flatpickr/dist/flatpickr.css';

  const Arabic = require("flatpickr/dist/l10n/ar.js").ar;

    export default {
        data() {
        return {
            editForm: new Form({
                name: '',
                date: '',
                notes: '',
                completed: ''
            }),
            config: {
                locale: Arabic
            },
            id: ''
        };
        },
        methods: {
        onTodoUpdate() {
            this.editForm.patch('/todos/' + this.id)
                .then(response => eventBus.$emit('todoUpdated', response));
            },
        editTodoModal(todo){
            this.editForm.reset();
            this.editForm.name = todo.name;
            this.editForm.date = todo.date;
            this.editForm.notes = todo.notes;
            this.editForm.completed = todo.completed;
            this.id = todo.id;
            }
        },
        created(){
            eventBus.$on('editTodo', todo => this.editTodoModal(todo));
        },
        components: {
            flatPickr
        }

    }
</script>
