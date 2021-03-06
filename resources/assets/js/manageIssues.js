
require('./bootstrap');

window.Vue = require('vue');

import VueResource from 'vue-resource';
import VuePaginator from 'vuejs-paginator';

Vue.use(VueResource);


import Form from './partials/Form';
window.Form = Form;


import jquery from 'jquery';
import toastr from 'toastr';
import bootstrap from 'bootstrap';


import addIssue from './components/issue/addIssue.vue';
import editIssue from './components/issue/editIssue.vue';

window.eventBus = new Vue();

const manageIssues = new Vue({
    el: '#manageIssues',
    data: {
    	issues: [],
      people: [],
    	current_view: 'all',
    	resource_url: '/issues',
    	options: {
              remote_data: 'issues.data',
              remote_current_page: 'issues.current_page',
              remote_last_page: 'issues.last_page',
              remote_next_page_url: 'issues.next_page_url',
              remote_prev_page_url: 'issues.prev_page_url',
              next_button_text: 'التالى',
              previous_button_text: 'السابق'
            },
    },
   	methods: {
   		updateResource(data){
  			this.issues = data;
  		},
      afterIssueAdded(response){
        this.issues.unshift(response.item);
        $('#addIssue').modal('hide');
        toastr.success(response.message);
      },
      editIssue(issue){
        eventBus.$emit('editIssue', issue);
        $('#editIssue').modal('show');
      },
      afterIssueUpdated(response){
        $('#editIssue').modal('hide');
        toastr.info(response.message);
        this.reloadData();
      },
      deleteIssue(issue){
        if(confirm('هل انت متاكد من حذف هذا التوكيل')){
        axios.delete('/issues/' + issue.id)
        .then(response => this.onIssueDelete(response));
      }
      },
      onIssueDelete(response){
        this.reloadData();
        toastr.warning(response.data.message);
      },
      fetchIssuesData(){
        if(this.current_view == 'all'){
          axios.get('/issues')
          .then(response => this.assignData(response));
          this.resource_url = '/issues';
        } else {
          axios.get('/issue/' + this.current_view)
          .then(response => this.assignData(response));
          this.resource_url = '/issue/' + this.current_view;
        }
      },
      assignData(response){
          this.issues = response.data.issues.data;
          this.people = response.data.people;
      },
      reloadData(){
          this.$refs.VP.fetchData(this.resource_url + '?page=' + this.$refs.VP.current_page);
      },
      restore(issue){
        axios.get('/issues/' + issue.id + '/restore')
          .then(response => this.issueRestored(response));
      },
      issueRestored(response){
        this.reloadData();
        toastr.success(response.data.message);
      },
      openentType(person){
          let type = person.pivot.person_type;
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
      printTable(){
        $('.print-hidden').hide()
        $('.btn').hide()
        window.print()
        $('.print-hidden').show()
        $('.btn').show()
      }
   	},
    components: {
    	addIssue,
    	editIssue,
    	VPaginator: VuePaginator
    },
    created() {
      this.fetchIssuesData();

      eventBus.$on('IssueAdded', response => this.afterIssueAdded(response));
      
      eventBus.$on('IssueUpdated', response => this.afterIssueUpdated(response));
    }

});


toastr.options = {
  "positionClass": "toast-bottom-right",
}