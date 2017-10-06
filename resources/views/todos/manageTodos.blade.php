@extends('layouts/master')


@section('title', 'ادارة الاعمال الادارية')

	@section('css')
        <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
	@endsection

@section('content')

<div class="col-md-12 alert alert-success heading print-hidden">
	يمكنك التحكم فى الاعمال الادارية فى هذه الصفحة<br>
</div>

<div id="manageTodos">
		<div class="heading col-md-12 print-hidden">
			اعرض 
			<select v-model.number="current_view" @change="fetchTodosData()">
				<option value="0">الغير مكتملة</option>
				<option value="1">المكتملة</option>
			</select>
		</div>
		<table v-if="todos.length" class="table table-responsive table-striped table-bordered main-table">

			<span class="heading mr-auto">
				الاعمال الادارية المضافة فى التطبيق
			</span>
			<span class="mr-auto">
			<button class="btn btn-sm btn-success pull-left" data-toggle="modal" data-target="#addTodo">اضافة عما ادارى</button>
			<button v-if="todos.length && current_view == 0" @click="printTable()" class="btn btn-sm btn-info pull-left">طباعة الجدول</button>
			</span>
			<thead class="thead-inverse">
				<tr>
				<th>العمل الادارى</th>
				<th>التاريخ</th>
				<th>ملاحظات</th>
				<th class="print-hidden">انتهى ؟</th>
				<th class="print-hidden">الاعدادات</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="todo in todos" :key="todo.id">
					<td> @{{ todo.name }} </td>
					<td> @{{ todo.date }} </td>
					<td> @{{ todo.notes }} </td>
					<td class="print-hidden">
						<input type="checkbox" id="checkbox" :checked="todo.completed"> 
					</td>
					<td class="print-hidden">
						<button @click="editTodo(todo)" data-toggle="modal" class="btn btn-sm btn-info" type="button">تـعــديل</button>
						<button @click="deleteTodo(todo)" class="btn btn-sm btn-danger" type="button">حـذف</button>
					</td>
				</tr>
			</tbody>
		</table>
		<br>
		<v-paginator class="heading" v-if="todos.length" :options="options" ref="VP"  :resource_url="resource_url" @update="updateResource"></v-paginator>
		<br>



	  		<!-- Create todo Modal -->

	  		<add-person></add-person>
	  		
	  		<!-- edit todo Modal -->

	  		<edit-person></edit-person>
</div>


@endsection

@section('js')
	<script src="{{ URL::asset('js/manageTodos.js') }}"></script>
@endsection
