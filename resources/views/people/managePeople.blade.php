@extends('layouts/master')


@section('title', 'ادارة الاشخاص')

	@section('css')
        <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
	@endsection

@section('content')

<div class="col-md-12 alert alert-success heading">
	يمكنك التحكم فى الاشخاص فى هذه الصفحة<br>
	يتم استخدام الاشخاص كاطراف فى القضايا فيما بعد سواء كانوا موكلين او خصوم او اطراف اخرى فى الخصومة
</div>

<div id="managePeople">
		<div class="heading col-md-12">
			اعرض 
			<select v-model="current_view">
				<option value="all">الكل</option>
				<option value="clients">الموكلين</option>
				<option value="notClients">الاطراف الاخرى</option>
				<option value="trashed">المحذوفين</option>
			</select>
		</div>
		<table v-if="people.length" class="table table-responsive table-striped table-bordered main-table">

			<span class="heading mr-auto">
				قائمة الاشخاص المضافة فى التطبيق
			</span>
			<span class="mr-auto">
			<button class="btn btn-sm btn-success pull-left" data-toggle="modal" data-target="#addPerson">اضافة شخص</button>
			<button class="btn btn-sm btn-info pull-left">طباعة الجدول</button>
			</span>
			<thead class="thead-inverse">
				<tr>
				<th>الاسم</th>
				<th>العنوان</th>
				<th>التليفون</th>
				<th>الحاله</th>
				<th class="print-hidden">الاعدادات</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="person in people" :key="person.id">
					<td><a :href="'/people/' + person.id"> @{{ person.name }} </a></td>
					<td> @{{ person.location }} </td>
					<td> @{{ person.phone }} </td>
					<td v-if="person.is_client">
						<span class="green"> مــوكـل </span> 
					</td>
					<td v-else>
						<span class="red"> ليس مـــوكــل </span> 
					</td>
					<td class="print-hidden">
						<button @click="editPerson(person)" data-toggle="modal" class="btn btn-sm btn-info" type="button">تـعــديل</button>
						<button @click="deletePerson(person)" class="btn btn-sm btn-danger" type="button">حـذف</button>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		<v-paginator class="heading" v-if="people.length" :options="options" ref="VP"  :resource_url="resource_url" @update="updateResource"></v-paginator>
		<br>



	  		<!-- Create Person Modal -->

	  		<add-person></add-person>
	  		
	  		<!-- edit Person Modal -->

	  		<edit-person></edit-person>
</div>


@endsection

@section('js')
	<script src="{{ URL::asset('js/managePeople.js') }}"></script>
@endsection
