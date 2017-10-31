<template>
	<div id="issueFiles" class="print-hidden">
        <!-- issue info -->
        <div class="card text-center mr-auto">
          <div class="card-header">
          <h4 class="card-title">
              ملفات القضية
              <button class="btn pull-left btn-dark" data-toggle="modal" data-target="#fileUploader">اضافة ملف</button>
          </h4>
          </div>
          <div class="panel-body">
            <table v-if="files.length" class="table table-striped table-bordered table-responsive">
              <thead class="thead-inverse">
                <tr>
                  <th float="right">
                  اســـم الـمــستند
                  </th>
                  <th>
                  حــجـــمه - امتداده
                  </th>
                  <th>
                  استعراض وتحميل
                  </th>
                  <th>
                  الاعدادات
                  </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="file in files">
                  <td>
                      {{ file.name }}
                  </td>
                  <td>
                      {{ file.size }} kb <br>
                      {{ file.type }}
                  </td>
                  <td>
                      <a target="_blank" :href="'/storage/' + file.link">
                        <button><i class="fa fa-download" aria-hidden="true"></i></button>
                      </a>
                  </td>
                  <td>
                      <button class="btn btn-info" @click="editFile(file)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                      <button class="btn btn-danger" @click="deleteFile(file)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </td>
                </tr>
            </tbody>
            </table>
          </div>
        </div>
        
        <file-uploader></file-uploader>
        <edit-file></edit-file>

      </div>

</template>


<script>
import fileUploader from '../../files/fileUploader';
import editFile from '../../files/editFile';

export default {
	props: ['issue', 'files'],
    methods: {
  	  fileAdded(){
  	  	this.reloadData();
  	  	toastr.success('تم اضافة الملف بنجاح!');
  	  },
      editFile(file){
        eventBus.$emit('editFile', file);
        $('#editFile').modal('show');
      },
      afterFileUpdated(response){
        $('#editFile').modal('hide');
        toastr.info(response.message);
        this.reloadData();
      },
	  reloadData(){
        eventBus.$emit('refetchIssueFiles');
      },
      deleteFile(file){
    	if(confirm('هل انت متاكد من حذف هذا الملف - لن تتمكن من استرجاعه فيما بعد!')){
    	axios.delete('/files/' + file.id)
    	.then(response => this.onFileDelete(response));
	   }
	  },
      onFileDelete(response){
        toastr.warning(response.data.message);
        this.reloadData();
      }
    },
    components: {
    	'file-uploader': fileUploader,
    	'edit-file': editFile
    },
    created(){
    	eventBus.$on('fileUploaded', event => this.fileAdded());
    	eventBus.$on('fileUpdated', response => this.afterFileUpdated(response));
    }
}


</script>