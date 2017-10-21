<template>
        <div class="modal fade" id="addCriminalChallenge" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة طعن </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onChallengeCreate" @keydown="CriminalChallengeForm.errors.clear($event.target.name)"
                @change="CriminalChallengeForm.errors.clear($event.target.name)"
                @input="CriminalChallengeForm.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="level" class="label">نوع الطعن:</label>
                        
                        <select id="level" name="level" class="form-control" v-model="CriminalChallengeForm.level">
                            <option v-if="issue.type == 1 && judgement.level == 1 && judgement.present == 0" value="2">مــعـــــارضة</option>

                            <option v-if="issue.type !== 12 && judgement.level <= 2" 
                            value="3">استـــئـناف</option>

                            <option v-if="issue.type == 1 && judgement.level == 3 && !judgement.present" value="4">معارضة استئنافية</option>

                            <option v-if="judgement.level >= 3 && judgement.present" value="5">نـــقـــض</option>
                        </select>

                        <span class="alert-danger" v-if="CriminalChallengeForm.errors.has('level')" v-text="CriminalChallengeForm.errors.get('level')"></span>
                    </div>

                    <div class="form-group">
                        <label for="date" class="label">التاريخ:</label>
                        
                        <flat-pickr v-model="CriminalChallengeForm.date" 
                        name="date" 
                        :config="config" 
                        placeholder="تاريخ الجلــسة">
                        </flat-pickr>

                        <span class="alert-danger" v-if="CriminalChallengeForm.errors.has('date')" v-text="CriminalChallengeForm.errors.get('date')"></span>
                    </div>

                    <div class="form-group">
                        <label for="decision" class="label">القرار:</label>
                        
                        <input type="text" id="decision" name="decision" class="form-control" v-model="CriminalChallengeForm.decision"> 

                        <span class="alert-danger" v-if="CriminalChallengeForm.errors.has('decision')" v-text="CriminalChallengeForm.errors.get('decision')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="CriminalChallengeForm.errors.any()">اضافة</button>
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
        props: ['issue'],
        data() {
            return {
                judgement: [],
                CriminalChallengeForm: new Form({
                    person_id: '',
                    parent_id: '',
                    judgement_id: '',
                    level: '',
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
        onChallengeCreate() {
            this.CriminalChallengeForm.post(window.location.pathname + '/meetings')
                .then(response => eventBus.$emit('meetingAdded', response));
            },
            addChallengeModal(judgement){
                this.judgement = judgement;
                this.CriminalChallengeForm.person_id = judgement.person_id;
                this.CriminalChallengeForm.judgement_id = judgement.id;
                $('#addCriminalChallenge').modal('show');
            }
        },
        components: {
            flatPickr
        },
        mounted(){
            eventBus.$on('addCriminalChallenge', judgement => this.addChallengeModal(judgement));
        }

    }
</script>
