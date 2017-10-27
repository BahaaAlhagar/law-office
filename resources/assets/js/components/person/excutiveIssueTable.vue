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
                  <th class="brown"><strong>رقم القضية</strong></th>
                	<th class="brown"><strong>مـوضـــوعها</strong></th>
                	<th class="brown"><strong>الخـصـــوم</strong></th>
                	<th class="brown"><strong>القرار</strong></th>
                	<th class="print-hidden"></th>
                </tr>
                <tr v-for="issue in data" :key="issue.id">
                	<td>
                		<a :href="'/issues/' + issue.id">
                		  <span v-show="issue.number">
                        {{ issue.number }} لسنة {{ issue.year }} ادارى
                      </span>
                      <span v-show="issue.adv_number">
                        <br>{{ issue.adv_number }} لسنة {{ issue.adv_year }} س
                      </span>
                		</a>
                	</td>
                	<td>{{ issue.subject }}</td>
                	<td>
                      <span v-if="issue.openents.length" v-for="openent in issue.openents" :key="openent.id">
                        <span>
                          <a :href="'/people/' + openent.id">{{ openent.name }}</a> / {{ openentType(openent) }} <br>
                        </span>
                      </span>
                	</td>
                	<td>
                    <span v-if="issue.meetings.length">
                	     {{ issue.meetings[0].date }} <br> {{ issue.meetings[0].decision }}
                    </span>
                	</td>
                	<td class="print-hidden">
                		<a :href="'/issues/' + issue.id">
                			<button class="btn btn-sm btn-dark pull-left"><i class="fa fa-balance-scale" aria-hidden="true"></i></button>
                		</a>
                	</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
</template>

<script>

	export default {
		props: ['header', 'data', 'id'],
		methods: {
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
	      }
		}
	}
</script>