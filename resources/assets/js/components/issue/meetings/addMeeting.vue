<template>
        <div class="modal fade" id="addMeeting" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة جلـــسة </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onMeetingCreate" @keydown="addMeetingForm.errors.clear($event.target.name)"
                @change="addMeetingForm.errors.clear($event.target.name)"
                @input="addMeetingForm.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="role" class="label">رقم الرول:</label>
                        
                        <input type="text" id="role" name="role" class="form-control" v-model="addMeetingForm.role"> 

                        <span class="alert-danger" v-if="addMeetingForm.errors.has('role')" v-text="addMeetingForm.errors.get('role')"></span>
                    </div>

                    <div class="form-group">
                        <label for="date" class="label">التاريخ:</label>
                        
                        <flat-pickr v-model="addMeetingForm.date" 
                        name="date" 
                        :config="config" 
                        placeholder="اختر الجلــسة">
                        </flat-pickr>

                        <span class="alert-danger" v-if="addMeetingForm.errors.has('date')" v-text="addMeetingForm.errors.get('date')"></span>
                    </div>

                    <div class="form-group">
                        <label for="decision" class="label">القرار:</label>
                        
                        <input type="text" id="decision" name="decision" class="form-control" v-model="addMeetingForm.decision"> 

                        <span class="alert-danger" v-if="addMeetingForm.errors.has('decision')" v-text="addMeetingForm.errors.get('decision')"></span>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="label">ملاحظات:</label>
                        
                        <textarea type="text" id="notes" name="notes" class="form-control" rows="5" v-model="addMeetingForm.notes"></textarea> 

                        <span class="alert-danger" v-if="addMeetingForm.errors.has('notes')" v-text="addMeetingForm.errors.get('notes')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="addMeetingForm.errors.any()">اضافة</button>
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
            addMeetingForm: new Form({
                person_id: '',
                parent_id: '',
                judgement_id: '',
                level: 1,
                role: '',
                date: '',
                decision: '',
                notes: ''
            }),
            config: {
                locale: Arabic
            }
        };
        },
        methods: {
        onMeetingCreate() {
            this.addMeetingForm.post(window.location.pathname + '/meetings')
                .then(response => eventBus.$emit('meetingAdded', response));
            }
        },
        components: {
            flatPickr
        }

    }
</script>
