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
                        <label for="name" class="label">الاسم:</label>
                        
                        <input type="text" id="name" name="name" class="form-control" v-model="form.name"> 

                        <span class="alert-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                    </div>

                    <div class="form-group">
                        <label for="date" class="label">التاريخ:</label>
                        
                        <input type="text" id="date" name="date" class="form-control" v-model="form.date"> 

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
    export default {
        data() {
        return {
            form: new Form({
                name: '',
                date: '',
                notes: ''
            })
        };
        },
        methods: {
        onTodoCreate() {
            this.form.post('/todos')
                .then(response => eventBus.$emit('todoAdded', response));
            }
        }

    }
</script>
