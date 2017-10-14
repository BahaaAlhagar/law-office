<template>
        <div class="modal fade" id="addOpenent" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة خصم فى قضية </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/" 
                @submit.prevent="onOpenentAdd" @keydown="form.errors.clear($event.target.name)" 
                @change="form.errors.clear($event.target.name)" 
                @input="form.errors.clear($event.target.name)"
                >


                    <div class="form-group">
                        <label for="openent" class="label">
                        الخصم: 
                        <span class="brown">يجب اضافة الخصم فى الاشخاص ليظهر هنا</span>
                        </label>
                        
                        <multiselect name="openent" id="openent" 
                        @input="form.errors.clear('openent')"
                        v-model="form.openent" 
                        :options="people" 
                        track-by="id" 
                        placeholder="اختر الخصم"
                        :custom-label="customLabel">
                        </multiselect> 

                        <span class="alert-danger" v-if="form.errors.has('openent')" v-text="form.errors.get('openent')"></span>
                    </div>

                    <div class="form-group">
                        <label for="type" class="label">صفة الخصم:</label>
                        
                        <select name="type" id="type" class="form-control" v-model.number="form.type">
                            <option v-if="issue.type <= 3" value="1">متـهـم</option>
                            <option v-if="issue.type <= 3" value="2">مجنى عليه</option>
                            <option v-if="issue.type <= 3" value="3">مدعى بالحق المدنى</option>
                            <option v-if="issue.type >= 5" value="4">مدعى</option>
                            <option v-if="issue.type >= 5" value="5">مدعى عليه</option>
                            <option v-if="issue.type == 4" value="6">شاكى</option>
                            <option v-if="issue.type == 4" value="7">مشكو فى حقه</option>
                        </select>

                        <span class="alert-danger" v-if="form.errors.has('type')" v-text="form.errors.get('type')"></span>
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
	import Multiselect from 'vue-multiselect'
    export default {
        name: 'addOpenent',
        data() {
        return {
            form: new Form({
                type: '',
                openent: ''
            }),
        };
        },
        props : ['issue', 'people'],
        methods: {
            onOpenentAdd() {
                this.form.post('/issue/' + issue.id + '/openents')
                    .then(response => eventBus.$emit('openentAdded', response));
            },
            customLabel(option) {
                return `${option.name} - ${option.location}`;
            }
        },
        components: { Multiselect }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>