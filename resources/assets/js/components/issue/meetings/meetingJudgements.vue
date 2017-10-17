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

            <button v-if="judgement.child_meeting == null" class="btn btn-sm btn-dark pull-left" 
            data-toggle="modal" 
            data-target="#addChallenge"> اضافة طعن </button>
            <button v-if="judgement.child_meeting == null" class="btn btn-sm btn-danger pull-left" @click="deleteJudgement(judgement)"><i class="fa fa-times" aria-hidden="true"></i></button>
            <button class="btn btn-sm btn-info pull-left" @click="editJudgement(judgement)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

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
      }
    },
    components: {
      addJudgement,
      editJudgement,
      addChallenge
    }
}


</script>