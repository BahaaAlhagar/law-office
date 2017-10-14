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
                        <th class="brown">الأسم</th>
                        <th class="brown">الصفة</th>
                    </tr>
                    <tr v-else>
                      <td colspan="2"> لا يوجد خصوم بعد </td>
                    </tr>
                    <tr v-for="openent in openents" :key="openent.id">
                        <td>
                        {{ openent.name }}
                        <button class="btn btn-sm btn-danger pull-left" @click="deleteOpenent(openent)"><i class="fa fa-times" aria-hidden="true"></i></button>
                        <button class="btn btn-sm btn-info pull-left" @click="editOpenent(openent)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                        </td>
                        <td>{{ openentType(openent) }}</td>
                    </tr>

                </tbody>
              </table>
          </div>
          <add-openent :issue="issue" :people="people"></add-openent>
          <edit-openent :issue="issue" :people="people"></edit-openent>
        </div>
</template>

<script>

import addOpenent from './addOpenent';
import editOpenent from './editOpenent';

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
        editOpenent(openent){
          eventBus.$emit('editOpenent', openent);
          $('#editOpenent').modal('show');
        },
        afterOpenentUpdated(response){
          $('#editOpenent').modal('hide');
          toastr.info(response.message);
          this.refreshIssueData();
        },
/*        deleteIssue(issue){
        if(confirm('هل انت متاكد من حذف هذه القضية')){
          axios.delete('/issues/' + issue.id)
          .then(response => this.onIssueDelete(response));
         }
        },
        onIssueDelete(response){
          toastr.warning(response.data.message);
          window.location.replace('/issues');
        },*/
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
        }
      },
  components: {
        'add-openent': addOpenent,
        'edit-openent': editOpenent
      },
  mounted() {
        eventBus.$on('openentAdded', response => this.afterOpenentAdded(response));
        eventBus.$on('openentUpdated', response => this.afterOpenentUpdated(response));
      }
}

</script>