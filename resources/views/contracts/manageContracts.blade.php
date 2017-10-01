@extends('layouts/master')


@section('title', 'ادارة التوكيلات')

	@section('css')
        <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
	@endsection

@section('content')

<div class="col-md-12 alert alert-success heading print-hidden">
		يمكنك اضافة او تعديل او حذف التوكيلات فى هذه الصفحة
</div>

<div id="manageContracts">
		<div class="heading col-md-12 print-hidden">
			اعرض 
			<select v-model="current_view" @change="fetchContractsData()">
				<option value="all">الكل</option>
				<option value="1">التوكيلات العامة</option>
				<option value="2">التوكيلات الخاصة</option>
				<option value="3">عقود الوكالة</option>
				<option value="trashed">المحذوفة</option>
			</select>
		</div>
		<table v-if="contracts.length" class="table table-responsive table-striped table-bordered main-table">

			<span class="heading mr-auto">
				قائمة التوكيلات المضافة فى التطبيق
			</span>
			<span class="mr-auto">
			<button class="btn btn-sm btn-success pull-left" data-toggle="modal" data-target="#addContract">اضافة توكيل</button>
			<button v-if="contracts.length" @click="printTable()" class="btn btn-sm btn-info pull-left">طباعة الجدول</button>
			</span>
			<thead class="thead-inverse">
				<tr>
				<th>الرقم</th>
				<th>النوع - المكتب</th>
				<th>رقم الفهرس</th>
				<th>الموكلين</th>
				<th class="print-hidden">الاعدادات</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="contract in contracts" :key="contract.id">
					<td> 
						@{{ contract.number }} لسنة @{{ contract.year }}<br>
						حرف @{{ contract.letter }}
					</td>

					<td v-if="contract.type == 1">
						<span class="brown">
							توكيل عام <br>
						</span>
					 	@{{ contract.office }} 
					</td>
					<td v-if="contract.type == 2">
						<span class="blue">
							توكيل خاص <br>
						</span>
					 	@{{ contract.office }} 
					</td>
					<td v-if="contract.type == 3">
						<span class="green">
							عقد وكالة <br>
						</span>
					 	@{{ contract.office }} 
					</td>

					<td> @{{ contract.archive_number }} </td>

					<td>
						<ul>
							<li v-for="person in contract.people">@{{ person.name }}</li>
						</ul>
					</td>

					<td v-if="current_view != 'trashed'" class="print-hidden">
						<button @click="editContract(contract)" data-toggle="modal" class="btn btn-sm btn-info" type="button">تـعــديل</button>
						<button @click="deleteContract(contract)" class="btn btn-sm btn-danger" type="button">حـذف</button>
					</td>
					<td v-else class="print-hidden">
						<button @click="restore(contract)" data-toggle="modal" class="btn btn-sm btn-success" type="button">استرجاع</button>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		<v-paginator class="heading" v-if="contracts.length" :options="options" ref="VP"  :resource_url="resource_url" @update="updateResource"></v-paginator>
		<br>



	  		<!-- Create Contract Modal -->

	  		<add-contract :people="people"></add-contract>
	  		
	  		<!-- edit Contract Modal -->

	  		<edit-contract></edit-contract>
</div>


@endsection

@section('js')
	<script src="{{ URL::asset('js/manageContracts.js') }}"></script>
@endsection
