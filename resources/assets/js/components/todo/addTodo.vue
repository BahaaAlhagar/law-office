<template>
        <div class="modal fade" id="addTodo" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة عمل ادارى </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onTodoCreate" @keydown="form.errors.clear($event.target.name)"
                @change="form.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="name" class="label">العمل الادارى:</label>
                        
                        <input type="text" id="name" name="name" class="form-control" v-model="form.name"> 

                        <span class="alert-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                    </div>

                    <div class="form-group">
                        <label for="date" class="label">التاريخ:</label>
                        
                        <flat-pickr v-model="form.date" 
                        name="date" 
                        :config="config" 
                        placeholder="اختر التاريخ">
                        </flat-pickr>

                        <span class="alert-danger" v-if="form.errors.has('date')" v-text="form.errors.get('date')"></span>
                    </div>


                    <div class="form-group">
                        <label for="notes" class="label">ملاحظات:</label>
                        
                        <input type="text" id="notes" name="notes" class="form-control" v-model="form.notes"> 

                        <span class="alert-danger" v-if="form.errors.has('notes')" v-text="form.errors.get('notes')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="form.errors.any()">اضافة</button>
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
            form: new Form({
                name: '',
                date: '',
                notes: ''
            }),
            config: {
                locale: Arabic
            }
        };
        },
        methods: {
        onTodoCreate() {
            this.form.post('/todos')
                .then(response => eventBus.$emit('todoAdded', response));
            }
        },
        components: {
            flatPickr
        }

    }
</script>
