<template>
	<span id="meetingJudgements">
        <!-- meeting judgements -->
        <!-- edit judgement modal out of type spans because it will be used by calling an event -->
        <edit-judgement :issue="issue"></edit-judgement>

        <!-- cevil issues -->
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
            <button v-if="judgement.child_meeting == null && judgement.present && judgement.level < 5" class="btn btn-sm btn-dark pull-left" 
            data-toggle="modal" 
            data-target="#addChallenge"> اضافة طعن </button>

            <!-- add challenge component if judgement doesnt have a child meeting -->
            <add-challenge v-if="judgement.child_meeting == null && judgement.level < 5" :judgement="judgement" :issue="issue"></add-challenge>

            <!-- add announcement if judgement is not present and doesnt have challenge(child meeting) -->
            <button v-if="judgement.child_meeting == null && !judgement.present" class="btn btn-sm btn-success pull-left" 
            @click="addAnnouncement(judgement)"> اضافة اعلان </button>

            <!-- add announcement component if judgement is not present and doesnt have challenge(child meeting) and meeting level is 1 -->
            <add-announcement v-if="judgement.child_meeting == null && !judgement.present && meeting.level == 1"></add-announcement>

            <!-- delete judgement if doesnt have challenge(child meeting) -->
            <button v-if="judgement.child_meeting == null" class="btn btn-sm btn-danger pull-left" @click="deleteJudgement(judgement)"><i class="fa fa-times" aria-hidden="true"></i></button>

            <!-- edit judgement -->
            <button class="btn btn-sm btn-info pull-left" @click="editJudgement(judgement)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>

          </ul>

        </span>




        <!-- criminal issues -->
        <span v-if="issue.type < 4">

          <!-- level 1 is complicated so we have seprate logic for it -->
          <!-- this data appears if meetings level is 1 and the meeting isnt set for certain openent -->
          <ul v-if="firstMeetingCheck(meeting)" v-for="openent in accusedopenents" :key="openent.id">
            <!-- check the openent person_type for result 1 then echo the name  -->
            <li>
              {{ echoName(openent) }}
              <button v-if="!openent.judgements.length"
              class="btn btn-sm btn-primary" 
              @click="addCriminalJudgement(openent)"> اضافة حكم </button>
              <!-- add judgement component -->
              <add-judgement :issue="issue" :meeting="meeting"></add-judgement>

                <ul v-for="currentJudgement in meeting.judgements" v-if="openent.id == currentJudgement.person_id">
                  <li>
                  {{ currentJudgement.body }}
                  </li>
                  <li v-if="currentJudgement.record">
                    حصر {{ currentJudgement.record }} لسنة {{ currentJudgement.year }}
                  </li>

                  <!-- add challenge if the judgement doesnt have challenge(child meeting) - and judgement type is 1 or 2 -->
                  <button v-if="!currentJudgement.child_meeting && currentJudgement.type < 3" class="btn btn-sm btn-dark pull-left" 
                  @click="addCriminalChallenge(currentJudgement)"> اضافة طعن </button>

                  <!-- add challenge component if the judgement doesnt have challenge(child meeting) - and judgement type is 1 or 2 -->
                  <add-challenge v-if="currentJudgement.child_meeting == null && currentJudgement.type < 3" :judgement="currentJudgement" :issue="issue"></add-challenge>


                  <!-- delete judgement if doesnt have challenge(child meeting) -->
                  <button v-if="currentJudgement.child_meeting == null" class="btn btn-sm btn-danger pull-left" @click="deleteJudgement(currentJudgement)"><i class="fa fa-times" aria-hidden="true"></i></button>

                  <!-- edit judgement -->
                  <button class="btn btn-sm btn-info pull-left" @click="editJudgement(currentJudgement)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                  <br><hr>
                </ul>
            </li>
          </ul>
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
  data(){
    return {
      workingOpenents: []
    };
  },
	props: ['issue', 'accusedopenents', 'meeting'],
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
      },
      // criminal logic starts here
      // check if the meeting have first meeting properties
      firstMeetingCheck(meeting){
        if(meeting.level == 1 && !meeting.person_id && !this.meetingHaveFullDelay(meeting)){
          return true;
        }
        return false;
      },
      // check if meeting is delayed for all openents or not
      meetingHaveFullDelay(meeting){
        if(meeting.child_meetings){
          for(var i = 0; i < meeting.child_meetings.length; i++)
          {
            if(meeting.child_meetings[i].person_id == null){
              return true;
              }
            return false;
            }
          } else{return false;}
      },
      // return silced names
      echoName(openent){
        return openent.name.slice(0, 12);
      },
      // add criminal judgement
      addCriminalJudgement(openent){
        $('#addJudgement').modal('show');
        eventBus.$emit('addCriminalJudgement', openent);
      },
      addCriminalChallenge(judgement){
        eventBus.$emit('addCriminalChallenge', judgement);
        $('#addChallenge').modal('show');
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