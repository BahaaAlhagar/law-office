@extends('layouts/master')


@section('title', 'ادارة التوكيلات')

	@section('css')
        <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
	@endsection

@section('content')

<div class="col-md-12 alert alert-success heading print-hidden">
		يمكنك اضافة او تعديل او حذف التوكيلات فى هذه الصفحة
</div>

<div id="managePeople">
		<div class="heading col-md-12 print-hidden">
			اعرض 
			<select v-model="current_view" @change="fetchPPLData()">
				<option value="all">الكل</option>
				<option value="clients">التوكيلات العاة</option>
				<option value="notClients">التوكيلات الخاصة</option>
				<option value="trashed">عقود الوكالة</option>
				<option value="trashed">الحذوفة</option>
			</select>
		</div>
		<table v-if="contracts.length" class="table table-responsive table-striped table-bordered main-table">

			<span class="heading mr-auto">
				قائمة التوكيلات المضافة فى التطبيق
			</span>
			<span class="mr-auto">
			<button class="btn btn-sm btn-success pull-left" data-toggle="modal" data-target="#addContract">اضافة توكيل</button>
			<button @click="printTable()" class="btn btn-sm btn-info pull-left">طباعة الجدول</button>
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
				<tr v-for="contract in people" :key="contract.id">
					<td><a :href="'/people/' + contract.id"> @{{ contract.name }} </a></td>
					<td> @{{ contract.location }} </td>
					<td> @{{ contract.phone }} </td>
					<td v-if="current_view == 'all' && contract.is_client">
						<span class="green"> مــوكـل </span> 
					</td>
					<td v-if="current_view == 'all' && !contract.is_client">
						<span class="red"> ليس مـــوكــل </span> 
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

	  		<add-contract></add-contract>
	  		
	  		<!-- edit Contract Modal -->

	  		<edit-contract></edit-contract>
</div>


@endsection

@section('js')
	<script src="{{ URL::asset('js/manageContracts.js') }}"></script>
@endsection
