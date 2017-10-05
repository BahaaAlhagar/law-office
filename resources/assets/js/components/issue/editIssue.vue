<template>
        <div class="modal fade" id="editIssue" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> تعديل قضية قضية </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/contracts" @submit.prevent="onIssueCreate" @keydown="editFrom.errors.clear($event.target.name)" 
                @change="editFrom.errors.clear($event.target.name)" 
                >
                    
                    <div class="form-group col-lg-6">
                        <label for="number" class="label">رقم القضية الجزئى:</label>
                        
                        <input type="text" id="number" name="number" class="form-control" v-model="editFrom.number"> 

                        <span class="alert-danger" v-if="editFrom.errors.has('number')" v-text="editFrom.errors.get('number')"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="year" class="label">لسنة:</label>
                        
                        <input type="text" id="year" name="year" class="form-control" v-model="editFrom.year"> 

                        <span class="alert-danger" v-if="editFrom.errors.has('year')" v-text="editFrom.errors.get('year')"></span>
                    </div>   


                    <div class="form-group col-lg-6">
                        <label for="adv_number" class="label">رقم القضية المستانف:</label>
                        
                        <input type="text" id="adv_number" name="adv_number" class="form-control" v-model="editFrom.adv_number"> 

                        <span class="alert-danger" v-if="editFrom.errors.has('adv_number')" v-text="editFrom.errors.get('adv_number')"></span>
                    </div>

                    <div class="form-group col-lg-6">
                        <label for="adv_year" class="label">لسنة (مستانف):</label>
                        
                        <input type="text" id="adv_year" name="adv_year" class="form-control" v-model="editFrom.adv_year"> 

                        <span class="alert-danger" v-if="editFrom.errors.has('adv_year')" v-text="editFrom.errors.get('adv_year')"></span>
                    </div>


                    <div class="form-group">
                        <label for="subject" class="label">موضوع الدعوى:</label>
                        
                        <input type="text" id="subject" name="subject" class="form-control" v-model="editFrom.subject"> 

                        <span class="alert-danger" v-if="editFrom.errors.has('subject')" v-text="editFrom.errors.get('subject')"></span>
                    </div>

                    <div class="form-group">
                        <label for="court" class="label">المحكمة:</label>
                        
                        <input type="text" id="court" name="court" class="form-control" v-model="editFrom.court"> 

                        <span class="alert-danger" v-if="editFrom.errors.has('court')" v-text="editFrom.errors.get('court')"></span>
                    </div>


                    <div class="form-group">
                        <label for="room" class="label">الدائرة:</label>
                        
                        <input type="text" id="room" name="room" class="form-control" v-model="editFrom.room"> 

                        <span class="alert-danger" v-if="editFrom.errors.has('room')" v-text="editFrom.errors.get('room')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="editFrom.errors.any()">تعديل</button>
                    </div>
                </form>

              </div>

            </div>

          </div>

        </div>
</template>

<script>
    export default {
        data() {
        return {
            editFrom: new Form({
                number: '',
                year: '',
                adv_number: '',
                adv_year: '',
                subject: '',
                court: '',
                room: ''
            }),
            id: ''
        };
        },
        methods: {
            onIssueCreate() {
                this.editFrom.patch('/issues/' + this.id)
                    .then(response => eventBus.$emit('IssueUpdated', response));
            },
            editIssueModal(issue){
                this.editFrom.number = issue.number;
                this.editFrom.year = issue.year;
                this.editFrom.adv_number = issue.adv_number;
                this.editFrom.adv_year = issue.adv_year;
                this.editFrom.subject = issue.subject;
                this.editFrom.court = issue.court;
                this.editFrom.room = issue.room;
                this.id = issue.id;
            }
        },
        created() {
            eventBus.$on('editIssue', issue => this.editIssueModal(issue));
        }
    }
</script>

