<template>
	<div id="issueMeetings">
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
                <tr v-for="meeting in meetings" :key="meeting.id">
                  <td>
                      {{ meeting.role }}
                  </td>
                  <td>
                      {{ meeting.date }}
                      <button v-if="!meeting.judgements.length && !meeting.child_meetings.length" class="btn btn-sm btn-danger pull-left" @click="deleteMeeting(meeting)"><i class="fa fa-times" aria-hidden="true"></i></button>
                      <button class="btn btn-sm btn-info pull-left" @click="editMeeting(meeting)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                      <button v-if="!meeting.judgements.length && !meeting.child_meetings.length" class="btn btn-sm btn-dark pull-left" @click="delayMeeting(meeting)">تأجيل</button>
                  </td>
                  <td>
                      {{ meeting.decision }}
                  </td>
                  <td>
                      {{ meeting.notes }}
                  </td>
                  <td>
                      <meeting-judgements :issue="issue" :openents="openents" :meeting="meeting"></meeting-judgements>
                  </td>
                </tr>
            </tbody>
            </table>
          </div>
        </div>
        
        <add-meeting></add-meeting>
        <edit-meeting></edit-meeting>
        <delay-meeting></delay-meeting>

      </div>

</template>


<script>
import addMeeting from './addMeeting';
import editMeeting from './editMeeting';
import delayMeeting from './delayMeeting';
import meetingJudgements from './meetingJudgements';

export default {
  data() {
    return {
      meetings: []
    };
  },
	props: ['issue', 'openents'],
    methods: {
      fetchIssueMeetings(){
        axios.get(window.location.pathname + '/meetings')
          .then(response => this.assignData(response));
      },
      assignData(response){
        this.meetings = response.data;
      },
  	  afterMeetingAdded(response){
  	  	this.fetchIssueMeetings();
        $('#addMeeting').modal('hide');
        $('#addChallenge').modal('hide');
  	  	toastr.success(response.message);
  	  },
      editMeeting(meeting){
        eventBus.$emit('editMeeting', meeting);
        $('#editMeeting').modal('show');
      },
      afterMeetingUpdated(response){
        $('#editMeeting').modal('hide');
        toastr.info(response.message);
        this.fetchIssueMeetings();
      },
      deleteMeeting(meeting){
      	if(confirm('هل انت متاكد من حذف هذه الجـــلــــسة - لن تتمكن من استرجاعها فيما بعد!')){
      	axios.delete('/meetings/' + meeting.id)
      	.then(response => this.onMeetingDelete(response));
    	   }
  	  },
      onMeetingDelete(response){
        toastr.warning(response.data.message);
        this.fetchIssueMeetings();
      },
      delayMeeting(meeting){
        eventBus.$emit('delayMeeting', meeting);
        $('#delayMeeting').modal('show');
      },
      afterMeetingDelayed(response){
        $('#delayMeeting').modal('hide');
        toastr.info(response.message);
        this.fetchIssueMeetings();
      },
      afterJudgementAdded(response){
        $('#addJudgement').modal('hide');
        toastr.success(response.message);
        this.fetchIssueMeetings();
      },
      afterJudgementUpdated(response){
        $('#editJudgement').modal('hide');
        toastr.info(response.message);
        this.fetchIssueMeetings();
      },
      afterJudgementDeleted(response){
        toastr.warning(response.data.message);
        this.fetchIssueMeetings();
      }
    },
    components: {
    	addMeeting,
      editMeeting,
      delayMeeting,
      meetingJudgements
    },
    mounted(){
      this.fetchIssueMeetings();

    	eventBus.$on('meetingAdded', response => this.afterMeetingAdded(response));
      eventBus.$on('meetingUpdated', response => this.afterMeetingUpdated(response));

    	eventBus.$on('meetingDelayed', response => this.afterMeetingDelayed(response));

      eventBus.$on('judgementAdded', response => this.afterJudgementAdded(response));

      eventBus.$on('judgementUpdated', response => this.afterJudgementUpdated(response));

      eventBus.$on('judgementDeleted', response => this.afterJudgementDeleted(response));

    }
}


</script>