<template>
        <div class="modal fade" id="editContract" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> تعديل توكيل </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/contracts" @submit.prevent="onContractUpdate" @keydown="editForm.errors.clear($event.target.name)" 
                @change="editForm.errors.clear($event.target.name)" 
                @input="editForm.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="number" class="label">رقم التوكيل:</label>
                        
                        <input type="text" id="number" name="number" class="form-control" v-model="editForm.number"> 

                        <span class="alert-danger" v-if="editForm.errors.has('number')" v-text="editForm.errors.get('number')"></span>
                    </div>

                    <div class="form-group">
                        <label for="year" class="label">سنة الاصدار:</label>
                        
                        <input type="text" id="year" name="year" class="form-control" v-model="editForm.year"> 

                        <span class="alert-danger" v-if="editForm.errors.has('year')" v-text="editForm.errors.get('year')"></span>
                    </div>


                    <div class="form-group">
                        <label for="letter" class="label">حرف السجل:</label>
                        
                        <input type="text" id="letter" name="letter" class="form-control" v-model="editForm.letter"> 

                        <span class="alert-danger" v-if="editForm.errors.has('letter')" v-text="editForm.errors.get('letter')"></span>
                    </div>

                    <div class="form-group">
                        <label for="type" class="label">نوع التوكيل:</label>
                        
                        <select name="type" id="type" class="form-control" v-model="editForm.type">
                        	<option value="1">توكيل عام</option>
                        	<option value="2">توكيل خاص</option>
                        	<option value="3">عقد وكالة</option>
                        </select> 

                        <span class="alert-danger" v-if="editForm.errors.has('type')" v-text="editForm.errors.get('type')"></span>
                    </div>

                    <div class="form-group">
                        <label for="office" class="label">مكتب الاصدار:</label>
                        
                        <input type="text" id="office" name="office" class="form-control" v-model="editForm.office"> 

                        <span class="alert-danger" v-if="editForm.errors.has('office')" v-text="editForm.errors.get('office')"></span>
                    </div>

                    <div class="form-group">
                        <label for="people" class="label">الموكل / الموكلين:</label>
                        
                        <multiselect name="people[]" id="people" 
                        @input="editForm.errors.clear('people')"
                        v-model="editForm.people" 
                        :options="people" 
                        :multiple="true" 
                        track-by="id" 
                        placeholder="اختر الموكل - الموكلين"
                        :custom-label="customLabel">
                        </multiselect> 

                        <span class="alert-danger" v-if="editForm.errors.has('people')" v-text="editForm.errors.get('people')"></span>
                    </div>

                    <div class="form-group">
                        <label for="archive_number" class="label">الرقم بفهرس المكتب:</label>
                        
                        <input type="text" id="archive_number" name="archive_number" class="form-control" v-model="editForm.archive_number"> 

                        <span class="alert-danger" v-if="editForm.errors.has('archive_number')" v-text="editForm.errors.get('archive_number')"></span>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="label">ملاحظات:</label>
                        
                        <textarea type="text" id="notes" name="notes" class="form-control" rows="5" v-model="editForm.notes"></textarea> 

                        <span class="alert-danger" v-if="editForm.errors.has('notes')" v-text="editForm.errors.get('notes')"></span>
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
	import Multiselect from 'vue-multiselect'
    export default {
        data() {
        return {
            editForm: new Form({
                number: '',
                year: '',
                letter: '',
                type: '',
                office: '',
                archive_number: '',
                notes: '',
                people: []
            }),
            id: ''
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
        onContractUpdate() {
            this.editForm.patch('/contracts/' + this.id)
                .then(response => eventBus.$emit('contractUpdated', response));
            },
        editContractModal(contract){
            this.editForm.reset();
        	this.editForm.number = contract.number;
        	this.editForm.year 	 = contract.year;
        	this.editForm.letter = contract.letter;
        	this.editForm.type   = contract.type;
        	this.editForm.office = contract.office;
        	this.editForm.people = contract.people;
            this.editForm.archive_number = contract.archive_number;
        	this.editForm.notes = contract.notes;
        	this.id = contract.id;
        },
        customLabel(option) {
                return `${option.name} - ${option.location}`;
            }
        },
        created(){
        	eventBus.$on('editContract', contract => this.editContractModal(contract));
        },
        components: { Multiselect }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>