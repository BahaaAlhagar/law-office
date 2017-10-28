<template>
      <div :id="id">
        <div class="card text-center mr-auto">
          <div class="card-header">
          <h4 class="card-title blue">{{ header }}</h4>
          </div>
          <div class="panel-body">
            <table class="table table-responsive">
              <tbody>
                <tr>
                  <th class="brown"><strong>الرول</strong></th>
                  <th class="brown"><strong>تاريخ الجلسة</strong></th>
                	<th class="brown"><strong>بيانات القضية</strong></th>
                	<th class="brown"><strong>الشخص - الخصوم</strong></th>
                	<th class="brown"><strong>المحكمة - الدائرة - القرار</strong></th>
                	<th class="print-hidden"></th>
                </tr>
                <tr v-for="meeting in data" :key="meeting.id" :class="levelCheck(meeting)">
                  <td>{{ meeting.role }}</td>
                  <td>
                      {{ dayFormat(meeting.date) }}
                  </td>
                  <td>
                    <a :href="'/issues/' + meeting.issue.id">
                      <span v-show="meeting.issue.number">
                        {{ meeting.issue.number }} لسنة {{ meeting.issue.year }} {{ issueType(meeting.issue) }}
                      </span>
                      <span v-show="meeting.issue.adv_number">
                        <br>{{ meeting.issue.adv_number }} لسنة {{ meeting.issue.adv_year }} س
                      </span>
                    </a>
                  </td>
                	<td v-if="meeting.person_id">
                      {{ meeting.person.name }} / مــتــهــم</td>
                	<td v-else>
                      <span v-if="meeting.issue.openents.length" v-for="openent in meeting.issue.openents" :key="openent.id">
                      <span>
                        {{ openent.name }} / {{ openentType(openent) }} <br>
                      </span>
                    </span>
                	</td>
                	<td>
                      <span v-if="meeting.issue.court">
                        {{ meeting.issue.court }} - {{ meeting.issue.room }} <br>
                      </span>
                      {{ meeting.decision }}
                	</td>
                	<td class="print-hidden">
                    <button class="btn btn-sm btn-info pull-left" @click="editMeeting(meeting)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                    <a :href="'/issues/' + meeting.issue.id">
                      <button class="btn btn-sm btn-dark pull-left"><i class="fa fa-balance-scale" aria-hidden="true"></i></button>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
            <edit-meeting></edit-meeting>
          </div>
        </div>
      </div>
</template>

<script>
  import editMeeting from '../issue/meetings/editMeeting';

	export default {
		props: ['header', 'data', 'id'],
		methods: {
        editMeeting(meeting){
          eventBus.$emit('editMeeting', meeting);
          $('#editMeeting').modal('show');
        },
	      openentType(openent){
          let type = openent.pivot.person_type;
          switch(type) {
            case 1: return "مــتــهــم"; break;
            case 2: return "مجنى عليه"; break;
            case 3: return "مدعى بالحق المدنى"; break;
            case 4: return "مدعى"; break;
            case 5: return "مدعى عليه"; break;
            case 6: return "شــاكى"; break;
            case 7: return "مشكو فى حقه"; break;
          	}
          },
	      issueType(issue){
          let type = issue.type;
          switch(type) {
            case 1: return 'جـنــح'; break;
            case 2: return 'جـنــايــات'; break;
            case 3: return 'مــخــالفــات'; break;
            case 4: return 'أدارى'; break;
            case 5: return 'مــدنـى جــزئى'; break;
            case 6: return 'مــدنـى كــلـى'; break;
            case 7: return 'صــحــة توقيــع'; break;
            case 8: return 'أســـرة'; break;
            case 9: return 'وراثــــات'; break;
            case 10: return 'تـجـــارى'; break;
            case 11: return 'أدارى(مجلــس الدولة)'; break;
            case 12: return 'اقتصـــادية'; break;
	          }
	      },
        dayFormat(meetingdate){
          var d = new Date(meetingdate);
          var days = ["الاحــد","الاثــنين","الثلاثــاء","الاربعــاء","الخمــيس","الجمـــعة","الســبت"];
          return days[d.getDay()] + ' ' + meetingdate;
        },
        levelCheck(meeting){
            if(meeting.level > 2){
              return 'table-info';
            }
            return false;
        }
		},
    components: {
      editMeeting
    }
	}
</script>