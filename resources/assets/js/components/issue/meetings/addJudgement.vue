<template>
        <div class="modal fade" id="addJudgement" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة حكم </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onJudgementCreate" @keydown="addJudgementForm.errors.clear($event.target.name)"
                @change="addJudgementForm.errors.clear($event.target.name)"
                @input="addJudgementForm.errors.clear($event.target.name)"
                >
                    
                    <div v-if="issue.type > 4 && meeting.level == 1" class="form-group">
                        <label for="present" class="label">حالة الحكم:</label>
                        
                        <select id="present" name="present" class="form-control" v-model="addJudgementForm.present">
                            <option value="1">حــضـــورى</option>
                            <option value="0">غــيــابــى</option>
                        </select>

                        <span class="alert-danger" v-if="addJudgementForm.errors.has('present')" v-text="addJudgementForm.errors.get('present')"></span>
                    </div>

                    <div v-else-if="issue.type < 4" class="form-group">
                        <label for="present" class="label">حالة الحكم:</label>
                        
                        <select id="present" name="present" class="form-control" v-model="addJudgementForm.present">
                            <option value="1">حــضـــورى</option>
                            <option value="0">غــيــابــى</option>
                        </select>

                        <span class="alert-danger" v-if="addJudgementForm.errors.has('present')" v-text="addJudgementForm.errors.get('present')"></span>
                    </div>
                    

                    <div v-if="issue.type < 4" class="form-group">
                        <label for="type" class="label">نوع الحكم:</label>
                        
                        <select id="type" name="type" class="form-control" v-model="addJudgementForm.type">
                            <option value="1">ادانــه</option>
                            <option value="2">براءه</option>
                            <option value="3">ايقاف</option>
                        </select>

                        <span class="alert-danger" v-if="addJudgementForm.errors.has('type')" v-text="addJudgementForm.errors.get('type')"></span>
                    </div>

                    <div class="form-group">
                        <label for="date" class="label">تاريخ الحكم:</label>
                        
                        <flat-pickr v-model="addJudgementForm.date" 
                        name="date" 
                        :config="config" 
                        placeholder="اختر تاريخ الحكم">
                        </flat-pickr>

                        <span class="alert-danger" v-if="addJudgementForm.errors.has('date')" v-text="addJudgementForm.errors.get('date')"></span>
                    </div>

                    <div class="form-group">
                        <label for="body" class="label">صيغة الحكم:</label>
                        
                        <textarea type="text" id="body" name="body" class="form-control" rows="5" v-model="addJudgementForm.body"></textarea> 

                        <span class="alert-danger" v-if="addJudgementForm.errors.has('body')" v-text="addJudgementForm.errors.get('body')"></span>
                    </div>

                    <div v-if="issue.type < 4" class="form-group">
                        <label for="record" class="label">رقم الحصر:</label>
                        
                        <input type="text" id="record" name="record" class="form-control" v-model="addJudgementForm.record"> 

                        <span class="alert-danger" v-if="addJudgementForm.errors.has('record')" v-text="addJudgementForm.errors.get('record')"></span>
                    </div>

                    <div v-if="issue.type < 4" class="form-group">
                        <label for="year" class="label">سنة الحصر:</label>
                        
                        <input type="text" id="year" name="year" class="form-control" v-model="addJudgementForm.year"> 

                        <span class="alert-danger" v-if="addJudgementForm.errors.has('year')" v-text="addJudgementForm.errors.get('year')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="addJudgementForm.errors.any()">اضافة الحكم</button>
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
        props: ['issue', 'meeting'],
        data() {
        return {
            addJudgementForm: new Form({
                issue_id: this.issue.id,
                person_id: '',
                active: 1,
                present: 1,
                type: 1,
                record: '',
                year: '',
                date: this.meeting.date,
                body: '',
                level: this.meeting.level
            }),
            config: {
                locale: Arabic
            }
        };
        },
        methods: {
        onJudgementCreate() {
            this.addJudgementForm.post('/meetings/' + this.meeting.id + '/judgements')
                .then(response => eventBus.$emit('judgementAdded', response));
            },
        addCriminalJudgementModal(openent){
            this.addJudgementForm.issue_id = this.issue.id;
            this.addJudgementForm.person_id = openent.id;
            this.addJudgementForm.date = this.meeting.date;
            this.addJudgementForm.level = this.meeting.level;
            this.addJudgementForm.active = 1;
            this.addJudgementForm.present = 1;
            this.addJudgementForm.type = 1;
            }
        },
        components: {
            flatPickr
        },
        mounted(){
            eventBus.$on('addCriminalJudgement', openent => this.addCriminalJudgementModal(openent));
        }
    }
</script>
