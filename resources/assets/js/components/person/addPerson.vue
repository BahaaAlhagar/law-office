<template>
        <div class="modal fade" id="addPerson" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة شخص </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onPersonCreate" @keydown="form.errors.clear($event.target.name)"
                @change="form.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="name" class="label">الاسم:</label>
                        
                        <input type="text" id="name" name="name" class="form-control" v-model="form.name"> 

                        <span class="alert-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                    </div>

                    <div class="form-group">
                        <label for="location" class="label">محل الاقامة:</label>
                        
                        <input type="text" id="location" name="location" class="form-control" v-model="form.location"> 

                        <span class="alert-danger" v-if="form.errors.has('location')" v-text="form.errors.get('location')"></span>
                    </div>


                    <div class="form-group">
                        <label for="phone" class="label">التليفون:</label>
                        
                        <input type="number" id="phone" name="phone" class="form-control" v-model="form.phone"> 

                        <span class="alert-danger" v-if="form.errors.has('phone')" v-text="form.errors.get('phone')"></span>
                    </div>

                    <div class="form-group">
                        <label for="idenity" class="label">الرقم القومى:</label>
                        
                        <input type="number" id="idenity" name="idenity" class="form-control" v-model="form.idenity"> 

                        <span class="alert-danger" v-if="form.errors.has('idenity')" v-text="form.errors.get('idenity')"></span>
                    </div>
                    <div class="form-group">
                        <label for="is_client" class="label">الحاله:</label>
                        
                        <select id="is_client" name="is_client" class="form-control" v-model="form.is_client">
                            <option value="1" selected>مــوكــل</option>
                            <option value="0">لــيــس مــوكــل</option>
                        </select>

                        <span class="alert-danger" v-if="form.errors.has('active')" v-text="form.errors.get('active')"></span>
                    </div>

                    <div class="form-group heading">
                        <button type="submit" class="button btn-lg btn-success" :disabled="form.errors.any()">اضــافــة</button>
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
                location: '',
                phone: '',
                idenity: '',
                is_client: '',
            })
        };
        },
        methods: {
        onPersonCreate() {
            this.form.post('/people')
                .then(response => eventBus.$emit('personAdded', response));
            }
        }

    }
</script>
