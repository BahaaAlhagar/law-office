<template>
	<span id="meetingJudgements">
        <!-- meeting judgements -->
        <!-- cevil issues -->
        <span v-if="issue.type > 4">
          <span v-show="!meeting.judgements.length && !meeting.child_meetings.length">
            <button class="btn btn-sm btn-primary" 
            data-toggle="modal" 
            data-target="#addJudgement"> اضافة حكم </button>
            <add-judgement :issue="issue" :meeting="meeting"></add-judgement>
          </span>

          <ul v-show="meeting.judgements.length" v-for="judgement in meeting.judgements">
            <li>{{ judgement.body }}</li>

            <button v-show="judgement.child_meeting == undefined" class="btn btn-sm btn-dark pull-left" 
            data-toggle="modal" 
            data-target="#addChallenge"> اضافة طعن </button>

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
import addChallenge from './addChallenge';

export default {
  data() {
    return {
    };
  },
	props: ['issue', 'openents', 'meeting'],
    methods: {
      
    },
    components: {
      addJudgement,
      addChallenge
    }
}


</script>