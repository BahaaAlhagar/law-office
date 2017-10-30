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

      <div id="lateMeetings">
        <!-- list Records -->
        <div class="heading col-md-12">
			عرض الجلسات السابقة التى لم يتم تسجيل قراراتها بعد لاستكمال قراراتها
			<button @click="printPage()" class="btn btn-sm btn-success pull-left">طباعة الصفحة</button>
		</div>

        <div v-if="!fetched">
          <div class="spacer"></div>
          <div class="heading alert alert-warning">
            جارى التحميل..
          </div>
        </div>

        <div v-if="fetched">
    		<!-- cevil late Meetings -->
    		<div>
    			<span v-if="cevil_meetings.length">
    				<button class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#cevil_meetings"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                	<late-meetings-table :header="'الجلسات المدنية والتجارية'" :id="'cevil_meetings'" :data="cevil_meetings"></late-meetings-table>
                </span>
                <span v-else class="alert alert-info heading col-xs-12">
                	لا توجد جلسات مدنية او تجارية او ادارية سابقة بدون قرارت
                </span>
            </div>

            <!-- space -->
            <div class="spacer"></div>


            <!-- criminal late Meetings -->
    		<div>
    			<span v-if="criminal_meetings.length">
    				<button class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#criminal_meetings"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                	<late-meetings-table :header="'الجلسات الجنائية'" :id="'criminal_meetings'" :data="criminal_meetings"></late-meetings-table>
                </span>
                <span v-else class="alert alert-info heading col-xs-12">
                	لا توجد جلسات جنائية سابقة بدون قرارت
                </span>
            </div>
        </div>

      </div>
      <div class="spacer"></div>
@endsection


@section('js')

<script src="{{ URL::asset('js/lateMeetings.js') }}"></script>
@endsection