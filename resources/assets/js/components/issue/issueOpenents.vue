<template>
        <div class="card text-center mr-auto">
          <div class="card-header">
          <h4 class="card-title">
          خصوم القضية
          <span></span>
          <button class="btn pull-left btn-dark" data-toggle="modal" data-target="#addOpenent">اضافة خصم</button>
          </h4>
          </div>
          <div class="panel-body">
            <table class="table table-striped table-bordered table-responsive">
                <tbody>
                    <tr v-if="openents.length">
                        <th>الأسم</th>
                        <th>الصفة</th>
                    </tr>
                    <tr v-else>
                      <td colspan="2"> لا يوجد خصوم بعد </td>
                    </tr>
                    <tr v-for="person in openents" :key="person.id">
                        <th>{{ person.name }}</th>
                        <th>{{ person.pivot.person_type }}</th>
                    </tr>

                </tbody>
              </table>
            <div class="mr-auto card-footer">
                <button class="btn btn-info" @click="editIssue(issue)">تعديل البيانات</button>
                <button class="btn btn-danger" @click="deleteIssue(issue)">حذف القضية</button>
            </div>
          </div>
          <add-openent :issue="issue" :people="people"></add-openent>
        </div>
</template>

<script>

import addOpenent from './addOpenent';

export default{
  props: ['issue', 'people', 'openents'],
  methods: {
        refreshIssueData(){
          eventBus.$emit('refetchIssueInfo');
        },
        afterOpenentAdded(response)
        {
          $('#addOpenent').modal('hide');
          toastr.success(response.message);
          this.refreshIssueData();
        },
/*        editIssue(issue){
          eventBus.$emit('editIssue', issue);
          $('#editIssue').modal('show');
        },
        afterIssueUpdated(response){
          $('#editIssue').modal('hide');
          toastr.info(response.message);
          this.refreshIssueData();
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
        },*/
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
        'add-openent': addOpenent
      },
  mounted() {
        eventBus.$on('openentAdded', response => this.afterOpenentAdded(response));
      }
}

</script>