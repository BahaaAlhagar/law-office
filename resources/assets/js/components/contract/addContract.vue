<template>
        <div class="modal fade" id="addContract" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة توكيل </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/contracts" @submit.prevent="onContractCreate" @keydown="form.errors.clear($event.target.name)" 
                @change="form.errors.clear($event.target.name)" 
                @input="form.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="number" class="label">رقم التوكيل:</label>
                        
                        <input type="text" id="number" name="number" class="form-control" v-model="form.number"> 

                        <span class="alert-danger" v-if="form.errors.has('number')" v-text="form.errors.get('number')"></span>
                    </div>

                    <div class="form-group">
                        <label for="year" class="label">سنة الاصدار:</label>
                        
                        <input type="text" id="year" name="year" class="form-control" v-model="form.year"> 

                        <span class="alert-danger" v-if="form.errors.has('year')" v-text="form.errors.get('year')"></span>
                    </div>


                    <div class="form-group">
                        <label for="letter" class="label">حرف السجل:</label>
                        
                        <input type="text" id="letter" name="letter" class="form-control" v-model="form.letter"> 

                        <span class="alert-danger" v-if="form.errors.has('letter')" v-text="form.errors.get('letter')"></span>
                    </div>

                    <div class="form-group">
                        <label for="type" class="label">نوع التوكيل:</label>
                        
                        <select name="type" id="type" class="form-control" v-model="form.type">
                        	<option value="1">توكيل عام</option>
                        	<option value="2">توكيل خاص</option>
                        	<option value="3">عقد وكالة</option>
                        </select> 

                        <span class="alert-danger" v-if="form.errors.has('type')" v-text="form.errors.get('type')"></span>
                    </div>

                    <div class="form-group">
                        <label for="office" class="label">مكتب الاصدار:</label>
                        
                        <input type="text" id="office" name="office" class="form-control" v-model="form.office"> 

                        <span class="alert-danger" v-if="form.errors.has('office')" v-text="form.errors.get('office')"></span>
                    </div>

                    <div class="form-group">
                        <label for="people" class="label">الموكل / الموكلين:</label>
                        
                        <multiselect name="people[]" id="people" 
                        @input="form.errors.clear('people')"
                        v-model="form.people" 
                        :options="people" 
                        :multiple="true" 
                        track-by="id" 
                        placeholder="اختر الموكل - الموكلين"
                        :custom-label="customLabel">
                        </multiselect> 

                        <span class="alert-danger" v-if="form.errors.has('people')" v-text="form.errors.get('people')"></span>
                    </div>

                    <div class="form-group">
                        <label for="archive_number" class="label">الرقم بفهرس المكتب:</label>
                        
                        <input type="text" id="archive_number" name="archive_number" class="form-control" v-model="form.archive_number"> 

                        <span class="alert-danger" v-if="form.errors.has('archive_number')" v-text="form.errors.get('archive_number')"></span>
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
        data() {
        return {
            form: new Form({
                number: '',
                year: '',
                letter: '',
                type: '',
                office: '',
                archive_number: '',
                people: []
            }),
        };
        },
        props : {
            people: {
                type: Array,
                default: function() {
                    return [];
                    }
                }
        },
        methods: {
            onContractCreate() {
                this.form.post('/contracts')
                    .then(response => eventBus.$emit('contractAdded', response));
            },
            customLabel(option) {
                return `${option.name} - ${option.location}`;
            }
        },
        components: { Multiselect }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>