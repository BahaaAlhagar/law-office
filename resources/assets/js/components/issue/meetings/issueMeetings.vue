<template>
	<div id="issueMeetings">
        <!-- issue meetings -->
        <div v-if="issue.type != 4" class="card text-center">
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
                  <th style="width: 400px;">الاحــكــــام</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="meeting in meetings" :key="meeting.id">
                  <td>
                      {{ meeting.role }}
                  </td>
                  <td>
                      <span class="text-center" style="display: block;">
                        {{ dayFormat(meeting.date) }}
                      </span>
                      <button v-if="!meeting.judgements.length && !meeting.child_meetings.length" class="btn btn-sm btn-danger pull-left" @click="deleteMeeting(meeting)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                      <button class="btn btn-sm btn-info pull-left" @click="editMeeting(meeting)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                      <button v-if="!meeting.judgements.length && !meeting.child_meetings.length" class="btn btn-sm btn-dark pull-left" @click="delayMeeting(meeting)">تأجيل</button>
                  </td>
                  <td>
                      {{ meeting.decision }}
                  </td>
                  <td>
                      {{ ownerOf(meeting) }}<br>
                      {{ meeting.notes }}
                  </td>
                  <td style="width: 400px;">
                      <meeting-judgements :issue="issue" :accusedopenents="accusedopenents" :meeting="meeting"></meeting-judgements>
                  </td>
                </tr>
            </tbody>
            </table>
          </div>
        </div>
        
        <add-meeting></add-meeting>
        <edit-meeting></edit-meeting>
        <delay-meeting></delay-meeting>


        <div v-if="issue.type == 4" class="card text-center">
          <div class="card-header">
          <h4 class="card-title">
              الـقـــرار
              <button v-if="!meetings.length" class="btn pull-left btn-success" data-toggle="modal" data-target="#addDecision">اضافة القرار</button>
          </h4>
          </div>
          <div class="panel-body">
            <table v-if="meetings.length" class="table table-striped table-bordered table-responsive">
              <thead class="thead-inverse">
                <tr>
                  <th>تـــاريخ القرار</th>
                  <th>القــرار</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="meeting in meetings" :key="meeting.id">
                  <td>
                      {{ meeting.date }}
                      <button v-if="!meeting.judgements.length && !meeting.child_meetings.length" class="btn btn-sm btn-danger pull-left" @click="deleteDecision(meeting)"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                      <button class="btn btn-sm btn-info pull-left" @click="editDecision(meeting)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                  </td>
                  <td>
                      {{ meeting.decision }}
                  </td>
                </tr>
            </tbody>
            </table>
          </div>
        </div>

        <add-decision></add-decision>
        <edit-decision></edit-decision>


      </div>

</template>


<script>
import addMeeting from './addMeeting';
import editMeeting from './editMeeting';
import delayMeeting from './delayMeeting';
import meetingJudgements from './meetingJudgements';
import addDecision from './addDecision';
import editDecision from './editDecision';
import moment from 'moment';
import 'moment-timezone';

export default {
	props: ['issue', 'accusedopenents', 'meetings'],
    methods: {
      ownerOf(meeting){
        if(meeting.person){
          return 'جلسة:' + meeting.person.name.slice(0, 12);
        }
      },
  	  afterMeetingAdded(response){
        eventBus.$emit('refetchIssueMeetings');
        $('#addMeeting').modal('hide');
        $('#addChallenge').modal('hide');
        $('#addCriminalChallenge').modal('hide');
  	  	toastr.success(response.message);
  	  },
      editMeeting(meeting){
        eventBus.$emit('editMeeting', meeting);
        $('#editMeeting').modal('show');
      },
      afterMeetingUpdated(response){
        $('#editMeeting').modal('hide');
        toastr.info(response.message);
        eventBus.$emit('refetchIssueMeetings');
      },
      deleteMeeting(meeting){
      	if(confirm('هل انت متاكد من حذف هذه الجـــلــــسة - لن تتمكن من استرجاعها فيما بعد!')){
      	axios.delete('/meetings/' + meeting.id)
      	.then(response => this.onMeetingDelete(response));
    	   }
  	  },
      onMeetingDelete(response){
        toastr.warning(response.data.message);
        eventBus.$emit('refetchIssueMeetings');
      },
      delayMeeting(meeting){
        eventBus.$emit('delayMeeting', meeting);
        $('#delayMeeting').modal('show');
      },
      afterMeetingDelayed(response){
        $('#delayMeeting').modal('hide');
        toastr.info(response.message);
        eventBus.$emit('refetchIssueMeetings');
      },
      afterJudgementAdded(response){
        $('#addJudgement').modal('hide');
        $('#addCriminalJudgement').modal('hide');
        toastr.success(response.message);
        eventBus.$emit('refetchIssueMeetings');
      },
      afterJudgementUpdated(response){
        $('#editJudgement').modal('hide');
        $('#addAnnouncement').modal('hide');
        toastr.info(response.message);
        eventBus.$emit('refetchIssueMeetings');
      },
      afterJudgementDeleted(response){
        toastr.warning(response.data.message);
        eventBus.$emit('refetchIssueMeetings');
      },
      afterDecisionAdded(){
        $('#addDecision').modal('hide');
        toastr.success('تم اضافة القرار بنجاح');
        eventBus.$emit('refetchIssueMeetings');
      },
      editDecision(meeting){
        eventBus.$emit('editDecision', meeting);
        $('#editDecision').modal('show');
      },
      afterDecisionUpdated(){
        $('#editDecision').modal('hide');
        toastr.success('تم تحديث القرار بنجاح');
        eventBus.$emit('refetchIssueMeetings');
      },
      deleteDecision(meeting){
        if(confirm('هل انت متاكد من حذف هذا القرار - لن تتمكن من استرجاعه فيما بعد!')){
          axios.delete('/meetings/' + meeting.id)
            .then(event => this.onDecisionDelete());
         }
      },
      onDecisionDelete(){
        toastr.warning('تم حذف القرار بنجاح');
        eventBus.$emit('refetchIssueMeetings');
      },
      dayFormat(meetingdate){
          var d = new moment(meetingdate).tz('Africa/Cairo');
          var days = ["الاحــد","الاثــنين","الثلاثــاء","الاربعــاء","الخمــيس","الجمـــعة","الســبت"];
          return days[d.day()] + ' ' + meetingdate;
      }
    },
    components: {
      addMeeting,
      addDecision,
    	editDecision,
      editMeeting,
      delayMeeting,
      meetingJudgements
    },
    mounted(){

      eventBus.$on('meetingAdded', response => this.afterMeetingAdded(response));

      eventBus.$on('DecisionAdded', event => this.afterDecisionAdded());

    	eventBus.$on('decisionUpdated', event => this.afterDecisionUpdated());
      
      eventBus.$on('meetingUpdated', response => this.afterMeetingUpdated(response));

    	eventBus.$on('meetingDelayed', response => this.afterMeetingDelayed(response));

      eventBus.$on('judgementAdded', response => this.afterJudgementAdded(response));

      eventBus.$on('judgementUpdated', response => this.afterJudgementUpdated(response));

      eventBus.$on('judgementDeleted', response => this.afterJudgementDeleted(response));

    }
}


</script>