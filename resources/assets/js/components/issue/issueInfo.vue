<template>
        <div class="card text-center mr-auto">
          <div class="card-header">
          <h4 class="card-title">
          بيانات القضية
          <span></span>
          <button class="btn pull-left btn-success" @click="printPage">طباعة الصفحة</button>
          </h4>
          </div>
          <div class="panel-body">
            <table class="table table-striped table-bordered table-responsive">
                <tbody>
                  <tr>
                    <td>رقم الدعـــوى</td>
                    <td>{{ issue.number }} لسنة {{ issue.year }} {{ issueType() }}</td>
                  </tr>
                  <tr>
                    <td>رقم الأستئـــناف</td>
                    <td>{{ issue.adv_number }} لسنة {{ issue.adv_year }} س</td>
                  </tr>
                  <tr>
                    <td>المحكمة</td>
                    <td>{{ issue.court }} - الدائــرة {{ issue.room }}
                    </td>
                  </tr>
                  <tr>
                    <td>موضــــوع الدعـــوى</td>
                    <td>{{ issue.subject }}</td>
                  </tr>
                </tbody>
              </table>
            <div class="mr-auto card-footer">
                <button class="btn btn-info" @click="editIssue(issue)">تعديل البيانات</button>
                <button class="btn btn-danger" @click="deleteIssue(issue)">حذف القضية</button>
            </div>
          </div>
          <edit-issue></edit-issue>
        </div>
</template>

<script>
import editIssue from './editIssue.vue';

export default{
  props: ['issue', 'people'],
  methods: {
        refreshIssueData(){
          eventBus.$emit('refetchIssueInfo');
        },
        editIssue(issue){
          eventBus.$emit('editIssue', issue);
          $('#editIssue').modal('show');
        },
        afterIssueUpdated(response){
          $('#editIssue').modal('hide');
          toastr.info(response.message);
          this.refreshIssueData()
        },
        deleteIssue(issue){
        if(confirm('هل انت متاكد من حذف هذه القضية')){
          axios.delete('/issues/' + issue.id)
          .then(response => this.onIssueDelete(response));
         }
        },
        onIssueDelete(response){
          toastr.warning(response.data.message);
          window.location.replace('/issues');
        },
        printPage(){
          $('.print-hidden').hide()
          $('.btn').hide()
          window.print()
          $('.print-hidden').show()
          $('.btn').show()
        },
        issueType(){
          let type = this.issue.type;
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
      },
  components: {
        editIssue
      },
  mounted() {
        eventBus.$on('IssueUpdated', response => this.afterIssueUpdated(response));
      }
}

</script>

