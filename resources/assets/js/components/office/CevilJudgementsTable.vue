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
                  <th class="brown"><strong>تاريخ الحكم</strong></th>
                	<th class="brown"><strong>بيانات القضية</strong></th>
                	<th class="brown"><strong>موضوع القضية</strong></th>
                  <th class="brown"><strong>صيغة الحكم</strong></th>
                  <th class="brown"><strong>اخر ميعاد للطعن</strong></th>
                	<th class="brown"><strong>الايام المتبقية</strong></th>
                	<th class="print-hidden"></th>
                </tr>
                <tr v-for="judgement in data" :key="judgement.id">
                  <td>
                      {{ judgement.date }}
                  </td>
                	<td>
                  		<a :href="'/issues/' + judgement.issue.id">
                        <span v-show="judgement.issue.number">
                          {{ judgement.issue.number }} لسنة {{ judgement.issue.year }} {{ issueType(judgement.issue) }}
                        </span>
                        <span v-show="judgement.issue.adv_number">
                          <br>{{ judgement.issue.adv_number }} لسنة {{ judgement.issue.adv_year }} س
                        </span>
                      </a>
                	</td>
                	<td>
                      {{ judgement.issue.subject }}
                  </td>
                	<td>
                      {{ judgement.body }}
                  </td>
                  <td class="red">
                      {{ judgement.valid_at }}
                	</td>
                  <td class="blue">
                      {{ daysLeft(judgement.valid_at) }}
                  </td>
                	<td class="print-hidden">
                		<a :href="'/issues/' + judgement.issue.id">
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
	      },
        judgementStatus(judgement){
          if(judgement.present){
            return 'ح';
          } else {
            return 'غ';
          }
        },
        judgementType(judgement){
          if(judgement.level < 3){
            return this.issueType(judgement.issue) + ' ' + judgement.issue.court;
          } else {
            return this.issueType(judgement.issue) + ' مستأنف ' + judgement.issue.court;
          }
        },
        daysLeft(endDate)
        {
          var oneDay = 24*60*60*1000;
          var today = new Date();
          var end = new Date(endDate);
          var daysLeft = (Math.ceil((end.getTime() - today.getTime())/(oneDay)));
          return daysLeft;
        }
		}
	}
</script>