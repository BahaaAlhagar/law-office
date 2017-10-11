<template>
        <div class="modal fade" id="fileUploader" role="dialog" aria-labelledby="myModalLabel">

          <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">

              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <span class="form-control-static pull-left">
                    <h4 class="modal-title" id="myModalLabel"> اضافة شخص </h4>
                </span>
              </div>

              <div class="modal-body">

              <dropzone id="Dropzone" :acceptedFileTypes="acceptedFiles" :url="url" :headers="csrfHeader">
                <!-- csrf token for laravel -->
                <input type="hidden" id="csrf-token" name="csrf-token" :value="csrfToken">
              </dropzone>

              </div>

            </div>

          </div>

        </div>
</template>

<script>

import Dropzone from 'vue2-dropzone'

export default {
  name: 'fileUploader',
  data() {
    return {
      csrfToken: $('meta[name="csrf-token"]').attr('content'),
      csrfHeader: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: window.location.pathname,
      acceptedFiles: '.jpg, .jpeg, .jpe, .png, .gif, .bmp, .doc, .docx, .dot, .word, .pdf, .xls, .ppt, .rar, .zip, .txt'
    };
  },
  components: {
      Dropzone
    }
}
</script>
