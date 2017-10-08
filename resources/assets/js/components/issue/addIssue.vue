<template>
        <div class="modal fade" id="addIssue" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة قضية </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/contracts" @submit.prevent="onIssueCreate" @keydown="form.errors.clear($event.target.name)" 
                @change="form.errors.clear($event.target.name)" 
                @input="editForm.errors.clear($event.target.name)"
                >
                    
                    <div class="form-group">
                        <label for="number" class="label">رقم القضية الجزئى:</label>
                        
                        <input type="text" id="number" name="number" class="form-control" v-model="form.number"> 

                        <span class="alert-danger" v-if="form.errors.has('number')" v-text="form.errors.get('number')"></span>
                    </div>

                    <div class="form-group">
                        <label for="year" class="label">لسنة:</label>
                        
                        <input type="text" id="year" name="year" class="form-control" v-model="form.year"> 

                        <span class="alert-danger" v-if="form.errors.has('year')" v-text="form.errors.get('year')"></span>
                    </div>   


                    <div class="form-group">
                        <label for="adv_number" class="label">رقم القضية المستانف:</label>
                        
                        <input type="text" id="adv_number" name="adv_number" class="form-control" v-model="form.adv_number"> 

                        <span class="alert-danger" v-if="form.errors.has('adv_number')" v-text="form.errors.get('adv_number')"></span>
                    </div>

                    <div class="form-group">
                        <label for="adv_year" class="label">لسنة (مستانف):</label>
                        
                        <input type="text" id="adv_year" name="adv_year" class="form-control" v-model="form.adv_year"> 

                        <span class="alert-danger" v-if="form.errors.has('adv_year')" v-text="form.errors.get('adv_year')"></span>
                    </div>

                    <div class="form-group">
                        <label for="type" class="label">نوع القضية <span class="red">(لا يمكنك تغيره فيما بعد)</span>:</label>
                        
                        <select name="type" id="type" class="form-control" v-model="form.type">
                        <option value="1">جــنــح</option>
                        <option value="2">جـنــايــات</option>
                        <option value="3">مــخــالفــات</option>
                        <option value="4">أدارى</option>
                        <option value="5">مــدنـى جــزئى</option>
                        <option value="6">مــدنـى كــلـى</option>
                        <option value="7">صــحــة توقيــع</option>
                        <option value="8">أســـرة</option>
                        <option value="9">وراثــــات</option>
                        <option value="10">تـجـــارى</option>
                        <option value="11">أدارى(مجلــس الدولة)</option>
                        <option value="12">اقتصـــادية</option>
                        </select> 

                        <span class="alert-danger" v-if="form.errors.has('type')" v-text="form.errors.get('type')"></span>
                    </div>

                    <div class="form-group">
                        <label for="subject" class="label">موضوع الدعوى:</label>
                        
                        <input type="text" id="subject" name="subject" class="form-control" v-model="form.subject"> 

                        <span class="alert-danger" v-if="form.errors.has('subject')" v-text="form.errors.get('subject')"></span>
                    </div>

                    <div class="form-group">
                        <label for="court" class="label">المحكمة:</label>
                        
                        <input type="text" id="court" name="court" class="form-control" v-model="form.court"> 

                        <span class="alert-danger" v-if="form.errors.has('court')" v-text="form.errors.get('court')"></span>
                    </div>


                    <div class="form-group">
                        <label for="room" class="label">الدائرة:</label>
                        
                        <input type="text" id="room" name="room" class="form-control" v-model="form.room"> 

                        <span class="alert-danger" v-if="form.errors.has('room')" v-text="form.errors.get('room')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="form.errors.any()">اضافة</button>
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
            form: new Form({
                number: '',
                year: '',
                adv_number: '',
                adv_year: '',
                type: '',
                subject: '',
                court: '',
                room: ''
            }),
        };
        },
        methods: {
            onIssueCreate() {
                this.form.post('/issues')
                    .then(response => eventBus.$emit('IssueAdded', response));
            }
        }
    }
</script>

