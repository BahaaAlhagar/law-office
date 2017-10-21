<template>
        <div class="modal fade" id="addCriminalJudgement" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة حكم </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onJudgementCreate" 
                @keydown="criminalJudgementForm.errors.clear($event.target.name)"
                @change="criminalJudgementForm.errors.clear($event.target.name)"
                @input="criminalJudgementForm.errors.clear($event.target.name)"
                >
                    

                    <div v-if="this.meeting.level !== 2 || this.meeting.level !== 4" class="form-group">
                        <label for="present" class="label">حالة الحكم:</label>
                        
                        <select id="present" name="present" class="form-control" v-model="criminalJudgementForm.present">
                            <option value="1">حــضـــورى</option>
                            <option value="0">غــيــابــى</option>
                        </select>

                        <span class="alert-danger" v-if="criminalJudgementForm.errors.has('present')" v-text="criminalJudgementForm.errors.get('present')"></span>
                    </div>
                    

                    <div v-if="issue.type < 4" class="form-group">
                        <label for="type" class="label">نوع الحكم:</label>
                        
                        <select id="type" name="type" class="form-control" v-model="criminalJudgementForm.type">
                            <option value="1">ادانــه</option>
                            <option value="2">براءه</option>
                            <option value="3">ايقاف</option>
                        </select>

                        <span class="alert-danger" v-if="criminalJudgementForm.errors.has('type')" v-text="criminalJudgementForm.errors.get('type')"></span>
                    </div>

                    <div class="form-group">
                        <label for="date" class="label">تاريخ الحكم:</label>
                        
                        <flat-pickr v-model="criminalJudgementForm.date" 
                        name="date" 
                        :config="config" 
                        placeholder="اختر تاريخ الحكم">
                        </flat-pickr>

                        <span class="alert-danger" v-if="criminalJudgementForm.errors.has('date')" v-text="criminalJudgementForm.errors.get('date')"></span>
                    </div>

                    <div class="form-group">
                        <label for="body" class="label">صيغة الحكم:</label>
                        
                        <textarea type="text" id="body" name="body" class="form-control" rows="5" v-model="criminalJudgementForm.body"></textarea> 

                        <span class="alert-danger" v-if="criminalJudgementForm.errors.has('body')" v-text="criminalJudgementForm.errors.get('body')"></span>
                    </div>

                    <div v-if="issue.type < 4" class="form-group">
                        <label for="record" class="label">رقم الحصر:</label>
                        
                        <input type="text" id="record" name="record" class="form-control" v-model="criminalJudgementForm.record"> 

                        <span class="alert-danger" v-if="criminalJudgementForm.errors.has('record')" v-text="criminalJudgementForm.errors.get('record')"></span>
                    </div>

                    <div v-if="issue.type < 4" class="form-group">
                        <label for="year" class="label">سنة الحصر:</label>
                        
                        <input type="text" id="year" name="year" class="form-control" v-model="criminalJudgementForm.year"> 

                        <span class="alert-danger" v-if="criminalJudgementForm.errors.has('year')" v-text="criminalJudgementForm.errors.get('year')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="criminalJudgementForm.errors.any()">اضافة الحكم</button>
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
            meeting: [],
            criminalJudgementForm: new Form({
                issue_id: this.issue.id,
                person_id: '',
                active: 1,
                present: 1,
                type: 1,
                record: '',
                year: '',
                date: '',
                body: '',
                level: ''
            }),
            config: {
                locale: Arabic
            }
        };
        },
        methods: {
        onJudgementCreate() {
            this.criminalJudgementForm.post('/meetings/' + this.meeting.id + '/judgements')
                .then(response => eventBus.$emit('judgementAdded', response));
            },
        addCriminalJudgementModal(openent, meeting){
            this.meeting = meeting;
            this.criminalJudgementForm.issue_id = this.issue.id;
            this.criminalJudgementForm.person_id = openent.id;
            this.criminalJudgementForm.date = meeting.date;
            this.criminalJudgementForm.level = meeting.level;
            this.criminalJudgementForm.active = 1;
            this.criminalJudgementForm.present = 1;
            this.criminalJudgementForm.type = 1;
            $('#addCriminalJudgement').modal('show');
            }
        },
        components: {
            flatPickr
        },
        mounted(){
            eventBus.$on('addCriminalJudgement', (openent, meeting) => this.addCriminalJudgementModal(openent, meeting));
        }
    }
</script>
