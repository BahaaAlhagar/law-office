@extends('layouts/master')

@section('meta')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    ارقام الحصر
@endsection

@section('css')
    <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
@endsection

@section('content')

      <div id="listRecords">
        <!-- list Records -->
        <div class="heading col-md-12 print-hidden">
			اعرض 
			<select v-model="current_view">
				<option value="1" selected>الاحكام الجزئية</option>
			    <option value="2">احكام الاستئناف</option>
			</select>
			<button @click="printPage()" class="btn btn-sm btn-info pull-left">طباعة الجدول</button>
		</div>


        <div v-if="!fetched">
          <div class="spacer"></div>
          <div class="heading alert alert-warning">
            جارى التحميل..
          </div>
        </div>

        <div v-if="fetched">
    		<!-- first level records -->
    		<div v-if="current_view == 1">
    			<span v-if="records.length">
                	<records-table :header="'ارقام الحصر الجزئية'" :id="'records'" :data="records"></records-table>
                </span>
                <span v-else class="alert alert-info heading col-xs-12">
                	لا توجد ارقام حصر جزئية
                </span>
            </div>

            <!-- advanced level records -->
            <div v-if="current_view == 2">
    			<span v-if="advanced_records.length">
                	<records-table :header="'ارقام الحصر الاستئنافية'" :id="'advanced_records'" :data="advanced_records"></records-table>
                </span>
                <span v-else class="alert alert-info heading col-xs-12">
                	لا توجد ارقام حصر الاستئنافية
                </span>
            </div>
        </div>


      </div>
      <div class="spacer"></div>
@endsection


@section('js')

<script src="{{ URL::asset('js/listRecords.js') }}"></script>
@endsection