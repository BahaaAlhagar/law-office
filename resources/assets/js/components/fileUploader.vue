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

              <form id="myDropzone" class="dropzone" method="post" :action="url"  enctype="multipart/form-data">
              <input type="hidden" id="csrf-token" name="_token" :value="csrfToken">

              <div class="dz-message" data-dz-message><span>اضغط هنا او اسحب الملفات للرفع</span></div>
              </form>

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
export default {
  name: 'fileUploader',
  data() {
    return {
      csrfToken: $('meta[name="csrf-token"]').attr('content'),
      csrfHeader: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: window.location.pathname,
      
    };
  },
}

Dropzone.options.myDropzone = {
      acceptedFiles: '.jpg, .jpeg, .jpe, .png, .gif, .bmp, .doc, .docx, .dot, .word, .pdf, .xls, .ppt, .rar, .zip, .txt',
      paramName: 'file',
      headers: {
          'X-CSRFToken': $('meta[name="token"]').attr('content')
      },
      dictResponseError: 'خطأ فى رفع الملف!',
      addRemoveLinks : true
    };

</script>
