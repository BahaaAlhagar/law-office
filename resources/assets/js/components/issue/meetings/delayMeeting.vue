<template>
        <div class="modal fade" id="delayMeeting" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> تأجيل جلـــسة {{ date }} </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onMeetingCreate" @keydown="delayMeetingForm.errors.clear($event.target.name)"
                @change="delayMeetingForm.errors.clear($event.target.name)"
                @input="delayMeetingForm.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="role" class="label">رقم الرول:</label>
                        
                        <input type="text" id="role" name="role" class="form-control" v-model="delayMeetingForm.role"> 

                        <span class="alert-danger" v-if="delayMeetingForm.errors.has('role')" v-text="delayMeetingForm.errors.get('role')"></span>
                    </div>

                    <div class="form-group">
                        <label for="date" class="label">التاريخ:</label>
                        
                        <flat-pickr v-model="delayMeetingForm.date" 
                        name="date" 
                        :config="config" 
                        placeholder="اختر تاريخ الجلــسة">
                        </flat-pickr>

                        <span class="alert-danger" v-if="delayMeetingForm.errors.has('date')" v-text="delayMeetingForm.errors.get('date')"></span>
                    </div>

                    <div class="form-group">
                        <label for="decision" class="label">القرار:</label>
                        
                        <input type="text" id="decision" name="decision" class="form-control" v-model="delayMeetingForm.decision"> 

                        <span class="alert-danger" v-if="delayMeetingForm.errors.has('decision')" v-text="delayMeetingForm.errors.get('decision')"></span>
                    </div>

                    <div class="form-group">
                        <label for="notes" class="label">ملاحظات:</label>
                        
                        <textarea type="text" id="notes" name="notes" class="form-control" rows="5" v-model="delayMeetingForm.notes"></textarea> 

                        <span class="alert-danger" v-if="delayMeetingForm.errors.has('notes')" v-text="delayMeetingForm.errors.get('notes')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="delayMeetingForm.errors.any()">اضافة</button>
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
            delayMeetingForm: new Form({
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
            },
            date: ''
        };
        },
        methods: {
        onMeetingCreate() {
            this.delayMeetingForm.post(window.location.pathname + '/meetings')
                .then(response => eventBus.$emit('meetingDelayed', response));
            },
        delayMeetingModal(meeting){
            this.delayMeetingForm.reset();
            this.delayMeetingForm.person_id = meeting.person_id;
            this.delayMeetingForm.parent_id = meeting.id;
            this.delayMeetingForm.level = meeting.level;
            this.date = meeting.date;
            },
        delayCriminalMeetingModal(meeting, openent)
            {
            this.delayMeetingForm.reset();
            this.delayMeetingForm.person_id = openent.id;
            this.delayMeetingForm.parent_id = meeting.id;
            this.delayMeetingForm.level = meeting.level;
            this.date = meeting.date;
            }
        },
        components: {
            flatPickr
        },
        mounted() {
            eventBus.$on('delayMeeting', meeting => this.delayMeetingModal(meeting));

            eventBus.$on('delayCriminalMeeting', (meeting, openent) => this.delayCriminalMeetingModal(meeting, openent));
        }


    }
</script>
