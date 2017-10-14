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


                <form method="POST" action="/contracts" 
                @submit.prevent="onOpenentAdd" @keydown="addOpenentForm.errors.clear($event.target.name)" 
                @change="addOpenentForm.errors.clear($event.target.name)" 
                @input="addOpenentForm.errors.clear($event.target.name)"
                >


                    <div class="form-group">
                        <label for="openent" class="label">
                        الخصم: 
                        <span class="brown">يجب اضافة الخصم فى الاشخاص ليظهر هنا</span>
                        </label>
                        
                        <multiselect name="openent" id="openent" 
                        @input="addOpenentForm.errors.clear('openent')"
                        v-model="addOpenentForm.openent" 
                        :options="people" 
                        track-by="id" 
                        placeholder="اختر الخصم"
                        :custom-label="customLabel">
                        </multiselect> 

                        <span class="alert-danger" v-if="addOpenentForm.errors.has('openent')" v-text="addOpenentForm.errors.get('openent')"></span>
                    </div>

                    <div class="form-group">
                        <label for="person_type" class="label">صفة الخصم:</label>
                        
                        <select name="person_type" id="person_type" class="form-control" v-model.number="addOpenentForm.person_type">
                            <option v-if="issue.type <= 3" value="1">متـهـم</option>
                            <option v-if="issue.type <= 3" value="2">مجنى عليه</option>
                            <option v-if="issue.type <= 3" value="3">مدعى بالحق المدنى</option>
                            <option v-if="issue.type >= 5" value="4">مدعى</option>
                            <option v-if="issue.type >= 5" value="5">مدعى عليه</option>
                            <option v-if="issue.type == 4" value="6">شاكى</option>
                            <option v-if="issue.type == 4" value="7">مشكو فى حقه</option>
                        </select>

                        <span class="alert-danger" v-if="addOpenentForm.errors.has('person_type')" v-text="addOpenentForm.errors.get('person_type')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="addOpenentForm.errors.any()">اضافة</button>
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
        data() {
        return {
            addOpenentForm: new Form({
                person_type: '',
                openent: ''
            }),
        };
        },
        props : ['issue', 'people'],
        methods: {
            onOpenentAdd() {
                this.addOpenentForm.post('/issues/' + this.issue.id + '/openents')
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