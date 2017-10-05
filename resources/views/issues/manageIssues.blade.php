@extends('layouts/master')


@section('title', 'ادارة القضايا')

	@section('css')
        <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
	@endsection

@section('content')

<div class="col-md-12 alert alert-success heading print-hidden">
		يمكنك اضافة او تعديل او حذف القضايا فى هذه الصفحة
</div>

<div id="manageIssues">
		<div class="heading col-md-12 print-hidden">
			اعرض 
			<select v-model="current_view" @change="fetchIssuesData()">
				<option value="all">الكل</option>
			    <option value="1">جــنــح</option>
			    <option value="2">جـنــايــات</option>
			    <option value="3">مــخــالفــات</option>
			    <option value="4">أدارى</option>
			    <option value="5">مــدنـى جــزئى</option>
			    <option value="6">مــدنـى كــلـى</option>
			    <option value="7">صــحــة توقيــع</option>
			    <option value="8">أســـرة</option>
			    <option value="9">وراثــــات</option>
			    <option value="10">تـجـــارى</option>
			    <option value="11">أدارى(مجلــس الدولة)</option>
			    <option value="12">اقتصـــادية</option>
				<option value="trashed">المحذوفة</option>
			</select>
		</div>
		<table v-if="issues.length" class="table table-responsive table-striped table-bordered main-table">

			<span class="heading mr-auto">
				قائمة القضايا المضافة فى التطبيق
			</span>
			<span class="mr-auto">
			<button class="btn btn-sm btn-success pull-left" data-toggle="modal" data-target="#addIssue">اضافة قضية</button>
			<button v-if="issues.length" @click="printTable()" class="btn btn-sm btn-info pull-left">طباعة الجدول</button>
			</span>
			<thead class="thead-inverse">
				<tr>
				<th>الرقم</th>
				<th>النوع - الموضوع</th>
				<th>المحكمة</th>
				<th>الخصوم</th>
				<th class="print-hidden">الاعدادات</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="issue in issues" :key="issue.id">
					<td> 
						<span v-if="issue.number">
							@{{ issue.number }} لسنة @{{ issue.year }}<br>
							@{{ issue.adv_number }} لسنة @{{ issue.adv_year }} س
						</span>
					</td>

					<td>
						<span v-if="issue.type == 1" class="brown">
							جــنــح <br>
						</span>
						<span v-if="issue.type == 2" class="red">
							جـنــايــات <br>
						</span>
						<span v-if="issue.type == 3" class="green">
							مــخــالفــات <br>
						</span>
						<span v-if="issue.type == 4" class="blue">
							أدارى <br>
						</span>
						<span v-if="issue.type == 5" class="blue">
							مــدنـى جــزئى <br>
						</span>
						<span v-if="issue.type == 6" class="green">
							مــدنـى كــلـى <br>
						</span>
						<span v-if="issue.type == 7" class="green">
							صــحــة توقيــع <br>
						</span>
						<span v-if="issue.type == 8" class="red">
							أســـرة <br>
						</span>
						<span v-if="issue.type == 9" class="brown">
							وراثــــات <br>
						</span>
						<span v-if="issue.type == 10" class="red">
							تـجـــارى <br>
						</span>
						<span v-if="issue.type == 11" class="green">
							أدارى(مجلــس الدولة) <br>
						</span>
						<span v-if="issue.type == 12" class="blue">
							اقتصـــادية <br>
						</span>

					 	@{{ issue.subject }} 
					</td>

					<td> @{{ issue.court }} <br> @{{ issue.room }} </td>

					<td>
						<ul>
							<li v-for="person in issue.people">@{{ person.name }}</li>
						</ul>
					</td>

					<td v-if="current_view != 'trashed'" class="print-hidden">
						<button @click="editIssue(issue)" data-toggle="modal" class="btn btn-sm btn-info" type="button">تـعــديل</button>
						<button @click="deleteIssue(issue)" class="btn btn-sm btn-danger" type="button">حـذف</button>
					</td>
					<td v-else class="print-hidden">
						<button @click="restore(issue)" data-toggle="modal" class="btn btn-sm btn-success" type="button">استرجاع</button>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		<v-paginator class="heading" v-if="issues.length" :options="options" ref="VP"  :resource_url="resource_url" @update="updateResource"></v-paginator>
		<br>



	  		<!-- Create issue Modal -->

	  		<add-issue></add-issue>
	  		
	  		<!-- edit issue Modal -->

	  		<edit-issue></edit-issue>
</div>


@endsection

@section('js')
	<script src="{{ URL::asset('js/manageIssues.js') }}"></script>
@endsection
