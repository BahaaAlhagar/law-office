<template>
      <div :id="id">
        <div class="card text-center mr-auto">
          <div class="card-header">
          <h4 class="card-title brown">{{ header }}</h4>
          </div>
          <div class="panel-body">
            <table class="table table-responsive">
              <tbody>
                <tr>
                	<th><strong>موضوع الدعوى</strong></th>
                	<th><strong>الخصوم</strong></th>
                	<th><strong>نوع الدعوى</strong></th>
                	<th><strong>تاريخ اخر جلسة</strong></th>
                	<th class="print-hidden"></th>
                </tr>
                <tr v-for="issue in data" :key="issue.id">
                  <td>
                      <a :href="/issues/ + issue.id">
                          <span v-if="issue.number">
                            {{ issue.number }} لسنة {{ issue.year }} {{ issueType(issue) }}
                          </span>
                      </a>
                  </td>
                	<td>
                		<a :href="/issues/ + issue.id">
                        {{ issue.subject }} 
                    </a>
                	</td>
                	<td>
                      <span v-if="issue.openents.length" v-for="openent in issue.openents" :key="openent.id">
                        <span>
                          {{ openent.name }} / {{ openentType(openent) }} <br>
                        </span>
                      </span>
                  </td>
                	<td>
                      <span v-if="issue.last_meeting_date">
                	       {{ dayFormat(issue.last_meeting_date) }} 
                      </span>
                	</td>
                	<td class="print-hidden">
                		<button class="btn btn-sm btn-info pull-left" @click="editIssue(issue)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                		<a :href="'/issues/' + issue.id">
                			<button class="btn btn-sm btn-dark pull-left"><i class="fa fa-balance-scale" aria-hidden="true"></i></button>
                		</a>
                	</td>
                	
                </tr>
              </tbody>
            </table>
          </div>
          <edit-issue></edit-issue>
        </div>
      </div>
</template>

<script>
	import editIssue from '../issue/editIssue';

	export default {
		props: ['header', 'data', 'id'],
		methods: {
		  editIssue(issue){
	        eventBus.$emit('editIssue', issue);
	        $('#editIssue').modal('show');
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
	      }
		},
		components: {
			editIssue
		}
	}
</script>