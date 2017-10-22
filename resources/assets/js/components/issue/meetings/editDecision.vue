<template>
        <div class="modal fade" id="editDecision" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> تعديل القرار </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onMeetingUpdate" @keydown="editDecisionForm.errors.clear($event.target.name)"
                @change="editDecisionForm.errors.clear($event.target.name)"
                @input="editDecisionForm.errors.clear($event.target.name)"
                >
                    

                    <div class="form-group">
                        <label for="date" class="label">التاريخ:</label>
                        
                        <flat-pickr v-model="editDecisionForm.date" 
                        name="date" 
                        :config="config" 
                        placeholder="اختر تاريخ القــرار">
                        </flat-pickr>

                        <span class="alert-danger" v-if="editDecisionForm.errors.has('date')" v-text="editDecisionForm.errors.get('date')"></span>
                    </div>

                    <div class="form-group">
                        <label for="decision" class="label">القرار:</label>
                        
                        <input type="text" id="decision" name="decision" class="form-control" v-model="editDecisionForm.decision"> 

                        <span class="alert-danger" v-if="editDecisionForm.errors.has('decision')" v-text="editDecisionForm.errors.get('decision')"></span>
                    </div>


                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="editDecisionForm.errors.any()">تعديل</button>
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
            editDecisionForm: new Form({
                date: '',
                decision: '',
                level: ''
            }),
            meeting_id: '',
            config: {
                locale: Arabic
            }
        };
        },
        methods: {
        onMeetingUpdate() {
            this.editDecisionForm.patch('/meetings/' + this.meeting_id)
                .then(response => eventBus.$emit('decisionUpdated'));
            },
        editDecisionModal(meeting){
            this.editDecisionForm.reset();
            this.editDecisionForm.decision = meeting.decision;
            this.editDecisionForm.date = meeting.date;
            this.editDecisionForm.level = meeting.level;
            this.meeting_id = meeting.id
            }
        },
        created(){
            eventBus.$on('editDecision', meeting => this.editDecisionModal(meeting));
        },
        components: {
            flatPickr
        }

    }
</script>
