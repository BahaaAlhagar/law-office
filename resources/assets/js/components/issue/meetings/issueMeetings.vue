<template>
	<div id="issueFiles" class="print-hidden">
        <!-- issue info -->
        <div class="card text-center">
          <div class="card-header">
          <h4 class="card-title">
              الـجـلــسات
              <button v-if="!meetings.length" class="btn pull-left btn-success" data-toggle="modal" data-target="#addMeeting">اضافة جلسة</button>
          </h4>
          </div>
          <div class="panel-body">
            <table v-if="meetings.length" class="table table-striped table-bordered table-responsive">
              <thead class="thead-inverse">
                <tr>
                  <th>الرول</th>
                  <th>تـــاريخ الجـــلــــسة</th>
                  <th>القــرار</th>
                  <th>مـــلاحــــظات</th>
                  <th>الاحــكــــام</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="meeting in meetings">
                  <td>
                      {{ meeting.role }}
                  </td>
                  <td>
                      {{ meeting.date }}
                  </td>
                  <td>
                      {{ meeting.decision }}
                  </td>
                  <td>
                      {{ meeting.notes }}
                  </td>
                  <td>
                      
                  </td>
                </tr>
            </tbody>
            </table>
          </div>
        </div>
        
        <!-- <file-uploader></file-uploader> -->
        <!-- <edit-file></edit-file> -->

      </div>

</template>


<script>
import addMeeting from '/addMeeting';
// import editMeeting from '/editMeeting';

export default {
  data() {
    return {
      meetings: []
    };
  },
	props: ['issue'],
    methods: {
      fetchIssueMeetings(){
        axios.get(window.location.pathname + '/meetings')
          .then(response => this.assignData(response));
      },
      assignData(response){
        this.meetings = response.data;
      }
  	  /*fileAdded(){
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
      }*/
    },
    components: {
    	addMeeting: addMeeting,
    },
    mounted(){
      this.fetchIssueMeetings();

    	eventBus.$on('fileUploaded', event => this.fileAdded());
    	eventBus.$on('fileUpdated', response => this.afterFileUpdated(response));
    }
}


</script>