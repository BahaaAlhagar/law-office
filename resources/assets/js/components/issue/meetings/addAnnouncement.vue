<template>
        <div class="modal fade" id="addAnnouncement" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة اعلان </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onJudgementUpdate" @keydown="addAnnouncementForm.errors.clear($event.target.name)"
                @change="addAnnouncementForm.errors.clear($event.target.name)"
                @input="addAnnouncementForm.errors.clear($event.target.name)"
                >

                    <div class="form-group">
                        <label for="date" class="label">تاريخ الاعلان:</label>
                        
                        <flat-pickr v-model="addAnnouncementForm.date" 
                        name="date" 
                        :config="config" 
                        placeholder="اختر تاريخ الاعلان">
                        </flat-pickr>

                        <span class="alert-danger" v-if="addAnnouncementForm.errors.has('date')" v-text="addAnnouncementForm.errors.get('date')"></span>
                    </div>


                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="addAnnouncementForm.errors.any()">اضافة اعلان</button>
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
            addAnnouncementForm: new Form({
                present: 1,
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
            this.addAnnouncementForm.patch('/judgements/' + this.judgement_id)
                .then(response => eventBus.$emit('judgementUpdated', response));
            },
        addAnnouncementModal(judgement){
            this.addAnnouncementForm.present = 1;
            this.addAnnouncementForm.body = judgement.body;
            this.addAnnouncementForm.type = judgement.type;
            this.addAnnouncementForm.active = judgement.active;
            this.addAnnouncementForm.level = judgement.level;
            this.judgement_id = judgement.id;
            }
        },
        components: {
            flatPickr
        },
        mounted() {
            eventBus.$on('addAnnouncement', judgement => this.addAnnouncementModal(judgement));
        }

    }
</script>
