<template>
        <div class="modal fade" id="fileUploader" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة ملف </h4>
                </span>
              </div>

              <div class="modal-body">

              <dropzone ref="myVueDropzone" v-on:vdropzone-success="showSuccess">
              </dropzone>

              <div class="heading alert alert-info" >
                الامتدادات المدعومة<br>
                jpg jpeg jpe png gif bmp doc docx dot word pdf xls ppt rar zip txt <br>
                لا يجوز ان يتخطى حجم الملف 2 ميجا.
              </div>

              </div>

            </div>

          </div>

        </div>
</template>

<script>
import Dropzone from './custom-dropzone';

export default {
  name: 'fileUploader',
  components: {
    Dropzone
  },
  methods: {
    showSuccess() {
      eventBus.$emit('fileUploaded');
    }
  }
}
</script>
