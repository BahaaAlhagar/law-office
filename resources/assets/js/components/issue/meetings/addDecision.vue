<template>
        <div class="modal fade" id="addDecision" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة قرار </h4>
                </span>
              </div>

              <div class="modal-body">


                <form method="POST" action="/people" @submit.prevent="onDecisionCreate" @keydown="addDesicionForm.errors.clear($event.target.name)"
                @change="addDesicionForm.errors.clear($event.target.name)"
                @input="addDesicionForm.errors.clear($event.target.name)"
                >
                    

                    <div class="form-group">
                        <label for="date" class="label">التاريخ:</label>
                        
                        <flat-pickr v-model="addDesicionForm.date" 
                        name="date" 
                        :config="config" 
                        placeholder="اختر تاريخ القرار">
                        </flat-pickr>

                        <span class="alert-danger" v-if="addDesicionForm.errors.has('date')" v-text="addDesicionForm.errors.get('date')"></span>
                    </div>

                    <div class="form-group">
                        <label for="decision" class="label">القرار:</label>
                        
                        <input type="text" id="decision" name="decision" class="form-control" v-model="addDesicionForm.decision"> 

                        <span class="alert-danger" v-if="addDesicionForm.errors.has('decision')" v-text="addDesicionForm.errors.get('decision')"></span>
                    </div>

                    <div class="form-group heading">
                        <button class="button btn-lg btn-success" :disabled="addDesicionForm.errors.any()">اضافة</button>
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
            addDesicionForm: new Form({
                level: 1,
                date: '',
                decision: '',
            }),
            config: {
                locale: Arabic
            }
        };
        },
        methods: {
        onDecisionCreate() {
            this.addDesicionForm.post(window.location.pathname + '/meetings')
                .then(response => eventBus.$emit('DecisionAdded'));
            }
        },
        components: {
            flatPickr
        }

    }
</script>
