<template>
	<span id="meetingJudgements">
        <!-- meeting judgements -->
        <!-- cevil issues -->
        <edit-judgement :issue="issue"></edit-judgement>
        <span v-if="issue.type > 4">
          <span v-if="!meeting.judgements.length && !meeting.child_meetings.length">
            <button class="btn btn-sm btn-primary" 
            data-toggle="modal" 
            data-target="#addJudgement"> اضافة حكم </button>
            <add-judgement :issue="issue" :meeting="meeting"></add-judgement>
          </span>

          <ul v-if="meeting.judgements.length" v-for="judgement in meeting.judgements">
            <li>{{ judgement.body }}</li>

            <!-- add challenge if the judgement is present and doesnt have challenge(child meeting) -->
            <button v-if="judgement.child_meeting == null && judgement.present" class="btn btn-sm btn-dark pull-left" 
            data-toggle="modal" 
            data-target="#addChallenge"> اضافة طعن </button>

            <!-- add announcement if judgement is not present and doesnt have challenge(child meeting) -->
            <button v-if="judgement.child_meeting == null && !judgement.present" class="btn btn-sm btn-success pull-left" 
            @click="addAnnouncement(judgement)"> اضافة اعلان </button>

            <!-- add announcement component if judgement is not present and doesnt have challenge(child meeting) -->
            <add-announcement v-if="judgement.child_meeting == null && !judgement.present"></add-announcement>

            <!-- delete judgement if doesnt have challenge(child meeting) -->
            <button v-if="judgement.child_meeting == null" class="btn btn-sm btn-danger pull-left" @click="deleteJudgement(judgement)"><i class="fa fa-times" aria-hidden="true"></i></button>

            <!-- edit judgement -->
            <button class="btn btn-sm btn-info pull-left" @click="editJudgement(judgement)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

            <!-- add challenge component -->
            <add-challenge :judgement="judgement" :issue="issue"></add-challenge>
          </ul>

        </span>

        <!-- criminal issues -->
        <span v-if="issue.type < 4">
          
        </span>

        <!-- executive issues -->
        <span v-if="issue.type == 4">
          
        </span>
  </span>

</template>


<script>
import addJudgement from './addJudgement';
import editJudgement from './editJudgement';
import addChallenge from './addChallenge';
import addAnnouncement from './addAnnouncement';

export default {
  data() {
    return {
    };
  },
	props: ['issue', 'openents', 'meeting'],
    methods: {
      editJudgement(judgement){
        eventBus.$emit('editJudgement', judgement);
        $('#editJudgement').modal('show');
      },
      deleteJudgement(judgement){
        if(confirm('هل انت متأكد من حذف هذا الحكم - لن تتمكن من استرجاعه فيما بعد'))
          {
            axios.delete('/judgements/' + judgement.id)
                .then(response => eventBus.$emit('judgementDeleted', response));
          }
      },
      addAnnouncement(judgement){
        eventBus.$emit('addAnnouncement', judgement);
        $('#addAnnouncement').modal('show');
      }
    },
    components: {
      addJudgement,
      editJudgement,
      addChallenge,
      addAnnouncement
    }
}


</script>