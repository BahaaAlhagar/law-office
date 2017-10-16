<template>
        <div class="modal fade" id="editMeeting" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> تعديل جلـــسة </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onMeetingUpdate" @keydown="editMeetingForm.errors.clear($event.target.name)"
                @change="editMeetingForm.errors.clear($event.target.name)"
                @input="editMeetingForm.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="role" class="label">رقم الرول:</label>
                        
                        <input type="text" id="role" name="role" class="form-control" v-model="editMeetingForm.role"> 

                        <span class="alert-danger" v-if="editMeetingForm.errors.has('role')" v-text="editMeetingForm.errors.get('role')"></span>
                    </div>

                    <div class="form-group">
                        <label for="date" class="label">التاريخ:</label>
                        
                        <flat-pickr v-model="editMeetingForm.date" 
                        name="date" 
                        :config="config" 
                        placeholder="اختر تاريخ الجلــسة">
                        </flat-pickr>

                        <span class="alert-danger" v-if="editMeetingForm.errors.has('date')" v-text="editMeetingForm.errors.get('date')"></span>
                    </div>

                    <div class="form-group">
                        <label for="decision" class="label">القرار:</label>
                        
                        <input type="text" id="decision" name="decision" class="form-control" v-model="editMeetingForm.decision"> 

                        <span class="alert-danger" v-if="editMeetingForm.errors.has('decision')" v-text="editMeetingForm.errors.get('decision')"></span>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="label">ملاحظات:</label>
                        
                        <textarea type="text" id="notes" name="notes" class="form-control" rows="5" v-model="editMeetingForm.notes"></textarea> 

                        <span class="alert-danger" v-if="editMeetingForm.errors.has('notes')" v-text="editMeetingForm.errors.get('notes')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="editMeetingForm.errors.any()">تعديل</button>
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
            editMeetingForm: new Form({
                person_id: '',
                parent_id: '',
                judgement_id: '',
                level: '',
                role: '',
                date: '',
                decision: '',
                notes: ''
            }),
            meeting_id: '',
            config: {
                locale: Arabic
            }
        };
        },
        methods: {
        onMeetingUpdate() {
            this.editMeetingForm.patch('/meetings/' + this.meeting_id)
                .then(response => eventBus.$emit('meetingUpdated', response));
            },
        editMeetingModal(meeting){
            this.editMeetingForm.reset();
            this.editMeetingForm.person_id = meeting.person_id;
            this.editMeetingForm.parent_id = meeting.parent_id;
            this.editMeetingForm.judgement_id = meeting.judgement_id;
            this.editMeetingForm.level = meeting.level;
            this.editMeetingForm.role = meeting.role;
            this.editMeetingForm.decision = meeting.decision;
            this.editMeetingForm.date = meeting.date;
            this.editMeetingForm.notes = meeting.notes;
            this.meeting_id = meeting.id;
            }
        },
        created(){
            eventBus.$on('editMeeting', meeting => this.editMeetingModal(meeting));
        },
        components: {
            flatPickr
        }

    }
</script>
