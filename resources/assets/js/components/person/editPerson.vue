<template>
        <div class="modal fade" id="editPerson" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> تعديل شخص </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onPersonUpdate" @keydown="editForm.errors.clear($event.target.name)"
                @change="editForm.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="name" class="label">الاسم:</label>
                        
                        <input type="text" id="name" name="name" class="form-control" v-model="editForm.name"> 

                        <span class="alert-danger" v-if="editForm.errors.has('name')" v-text="editForm.errors.get('name')"></span>
                    </div>

                    <div class="form-group">
                        <label for="location" class="label">محل الاقامة:</label>
                        
                        <input type="text" id="location" name="location" class="form-control" v-model="editForm.location"> 

                        <span class="alert-danger" v-if="editForm.errors.has('location')" v-text="editForm.errors.get('location')"></span>
                    </div>


                    <div class="form-group">
                        <label for="phone" class="label">التليفون:</label>
                        
                        <input type="text" id="phone" name="phone" class="form-control" v-model="editForm.phone"> 

                        <span class="alert-danger" v-if="editForm.errors.has('phone')" v-text="editForm.errors.get('phone')"></span>
                    </div>

                    <div class="form-group">
                        <label for="idenity" class="label">الرقم القومى:</label>
                        
                        <input type="text" id="idenity" name="idenity" class="form-control" v-model="editForm.idenity"> 

                        <span class="alert-danger" v-if="editForm.errors.has('idenity')" v-text="editForm.errors.get('idenity')"></span>
                    </div>
                    <div class="form-group">
                        <label for="is_client" class="label">الحاله:</label>
                        
                        <select id="is_client" name="is_client" class="form-control" v-model="editForm.is_client">
                            <option value="1" selected>مــوكــل</option>
                            <option value="0">لــيــس مــوكــل</option>
                        </select>

                        <span class="alert-danger" v-if="editForm.errors.has('is_client')" v-text="editForm.errors.get('is_client')"></span>
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
                name: '',
                location: '',
                phone: '',
                idenity: '',
                is_client: '',
            }),
            id: '',
        };
        },
        methods: {
        onPersonUpdate() {
            this.editForm.patch('/people/' + this.id)
                .then(response => eventBus.$emit('personUpdated', response));
            },
        editPersonModal(person){
        	this.editForm.name = person.name;
        	this.editForm.location = person.location;
        	this.editForm.phone = person.phone;
        	this.editForm.idenity = person.idenity;
        	this.editForm.is_client = person.is_client;
        	this.id = person.id;
        }
        },
        created(){
        	eventBus.$on('editPerson', person => this.editPersonModal(person));
        }

    }
</script>
