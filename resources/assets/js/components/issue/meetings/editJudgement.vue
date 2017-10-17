<template>
        <div class="modal fade" id="editJudgement" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> تعديل حكم </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onJudgementUpdate" @keydown="editJudgementForm.errors.clear($event.target.name)"
                @change="editJudgementForm.errors.clear($event.target.name)"
                @input="editJudgementForm.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="present" class="label">حالة الحكم:</label>
                        
                        <select id="present" name="present" class="form-control" v-model="editJudgementForm.present">
                            <option value="1">حــضـــورى</option>
                            <option value="0">غــيــابــى</option>
                        </select>

                        <span class="alert-danger" v-if="editJudgementForm.errors.has('present')" v-text="editJudgementForm.errors.get('present')"></span>
                    </div>

                    <div v-if="issue.type < 4" class="form-group">
                        <label for="type" class="label">نوع الحكم:</label>
                        
                        <select id="type" name="type" class="form-control" v-model="editJudgementForm.type">
                            <option value="1">ادانــه</option>
                            <option value="2">براءه</option>
                            <option value="3">ايقاف</option>
                        </select>

                        <span class="alert-danger" v-if="editJudgementForm.errors.has('type')" v-text="editJudgementForm.errors.get('type')"></span>
                    </div>

                    <div class="form-group">
                        <label for="date" class="label">تاريخ الحكم:</label>
                        
                        <flat-pickr v-model="editJudgementForm.date" 
                        name="date" 
                        :config="config" 
                        placeholder="اختر تاريخ الحكم">
                        </flat-pickr>

                        <span class="alert-danger" v-if="editJudgementForm.errors.has('date')" v-text="editJudgementForm.errors.get('date')"></span>
                    </div>

                    <div class="form-group">
                        <label for="body" class="label">صيغة الحكم:</label>
                        
                        <textarea type="text" id="body" name="body" class="form-control" rows="5" v-model="editJudgementForm.body"></textarea> 

                        <span class="alert-danger" v-if="editJudgementForm.errors.has('body')" v-text="editJudgementForm.errors.get('body')"></span>
                    </div>

                    <div v-if="issue.type < 4" class="form-group">
                        <label for="record" class="label">رقم الحصر:</label>
                        
                        <input type="text" id="record" name="record" class="form-control" v-model="editJudgementForm.record"> 

                        <span class="alert-danger" v-if="editJudgementForm.errors.has('record')" v-text="editJudgementForm.errors.get('record')"></span>
                    </div>

                    <div v-if="issue.type < 4" class="form-group">
                        <label for="year" class="label">سنة الحصر:</label>
                        
                        <input type="text" id="year" name="year" class="form-control" v-model="editJudgementForm.year"> 

                        <span class="alert-danger" v-if="editJudgementForm.errors.has('year')" v-text="editJudgementForm.errors.get('year')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="editJudgementForm.errors.any()">تعديل الحكم</button>
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
            editJudgementForm: new Form({
                present: '',
                active: '',
                type: 1,
                record: '',
                year: '',
                date: '',
                body: '',
                level: ''
            }),
            config: {
                locale: Arabic
            },
            judgement_id: ''
        };
        },
        methods: {
        onJudgementUpdate() {
            this.editJudgementForm.patch('/judgements/' + this.judgement_id)
                .then(response => eventBus.$emit('judgementUpdated', response));
            },
        editJudgementModal(judgement){
            this.editJudgementForm.present = judgement.present;
            this.editJudgementForm.active = judgement.active;
            this.editJudgementForm.type = judgement.type;
            this.editJudgementForm.record = judgement.record;
            this.editJudgementForm.year = judgement.year;
            this.editJudgementForm.date = judgement.date;
            this.editJudgementForm.body = judgement.body;
            this.editJudgementForm.level = judgement.level;
            this.judgement_id = judgement.id;
            }
        },
        components: {
            flatPickr
        },
        mounted() {
            eventBus.$on('editJudgement', judgement => this.editJudgementModal(judgement));
        }

    }
</script>
