<template>
	<span id="meetingJudgements">
        <!-- meeting judgements -->
        <!-- cevil issues -->
        <span v-if="issue.type > 4">
          <button v-show="!meeting.judgements.length && !meeting.child_meetings.length" 
          class="btn btn-sm btn-primary" 
          data-toggle="modal" 
          data-target="#addJudgement"> اضافة حكم </button>
          <add-judgement :issue="issue" :meeting="meeting"></add-judgement>
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

export default {
  data() {
    return {
    };
  },
	props: ['issue', 'openents', 'meeting'],
    methods: {
      
    },
    components: {
      addJudgement
    }
}


</script>