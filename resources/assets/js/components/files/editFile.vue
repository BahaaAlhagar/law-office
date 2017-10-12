<template>
        <div class="modal fade" id="editFile" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> تعديل ملف </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" enctype="multipart/form-data" @submit.prevent="onFileUpdate" @keydown="editForm.errors.clear($event.target.name)"
                @change="editForm.errors.clear($event.target.name)"
                @input="editForm.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="name" class="label">الاسم:</label>
                        
                        <input type="text" id="name" name="name" class="form-control" v-model="editForm.name"> 

                        <span class="alert-danger" v-if="editForm.errors.has('name')" v-text="editForm.errors.get('name')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="editForm.errors.any()">تـعــديــل</button>
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
            editForm: new Form({
                name: ''
            }),
            id: '',
        };
        },
        methods: {
        onFileUpdate() {
            this.editForm.patch('/files/' + this.id)
                .then(response => eventBus.$emit('fileUpdated', response));
            },
        editFileModal(file){
            this.editForm.reset();
        	this.editForm.name = file.name;
        	this.id = file.id;
        }
        },
        created(){
        	eventBus.$on('editFile', file => this.editFileModal(file));
        }

    }
</script>
