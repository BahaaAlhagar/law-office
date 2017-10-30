@extends('layouts/master')

@section('meta')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    الجلســـات
@endsection

@section('css')
    <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
@endsection

@section('content')

      <div id="mainPage">
        
        <div class="col-xs-12 print-hidden">
           <button class="btn pull-left btn-success" @click="printPage">طباعة الصفحة</button>
        </div><br>


        <!-- space -->
        <div class="spacer"></div>

        
        <div v-if="!fetched">
          <div class="heading alert alert-warning">
            جارى التحميل..
          </div>
        </div>

        <div v-if="fetched">
        	<!-- today Meetings -->
	        <div>
	        	<span v-if="today_meetings.length">
	            	<button class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#today_meetings"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
	            	<meetings-table :header="'جلسات اليوم'" :id="'today_meetings'" :data="today_meetings"></meetings-table>
	            </span>
	            <span v-else class="alert alert-info heading col-xs-12">
	            	لا يوجد جلسات اليوم
	            </span>
	        </div>

	        <!-- tomorrow Meetings -->
	        <div>
	        	<span v-if="tomorrow_meetings.length">
	            	<button class="btn btn-sm btn-dark pull-left" data-toggle="collapse" data-target="#tomorrow_meetings"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
	            	<meetings-table :header="'جلسات الغد'" :id="'tomorrow_meetings'" :data="tomorrow_meetings"></meetings-table>
	            </span>
	            <span v-else class="alert alert-info heading col-xs-12">
	            	لا يوجد جلسات الغد
	            </span>
	        </div>


            <!-- not present cevil judgements -->
            <div>
              <span v-if="not_present_judgements.length">
                  <button class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#not_present_judgements"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                    <not-present-table :header="'احكام مدنية غيابية لم تعلن بعد'" :id="'not_present_judgements'" :data="not_present_judgements"></not-present-table>
              </span>
              <span v-else class="alert alert-info heading print-hidden col-xs-12">
                لا توجد احكام مدنية غيابية لم تعلن بعد
              </span>
            </div>
            
            <!-- space -->
            <div class="spacer"></div>

            <!-- warning -->
            <div v-show="first_judgements.length || late_judgements.length" class="alert alert-danger heading print-hidden">
                  مـلـحـــوظة : سيظهر الحكم المدنى او التجارى لمدة 10 ايام بعد انتهاء مدة الطعن, وذلك لأتخاذ اجراءات تنفيذه.
            </div>

            <div>
              <!-- first level cevil judgements -->
              <span v-if="first_judgements.length">
                  <button class="btn btn-sm btn-warning pull-left" data-toggle="collapse" data-target="#first_judgements"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                    <cevil-judgements-table :header="'احكام الدرجة الاولى المدنية والتجارية الصادرة منذ اقل من 50 يوما ولم يتم الطعن فيها '" :id="'first_judgements'" :data="first_judgements"></cevil-judgements-table>
              </span>
              <span v-else class="alert alert-info heading print-hidden col-xs-12">
                لا توجد احكام الدرجة الاولى المدنية والتجارية الصادرة منذ اقل من 50 يوما ولم يتم الطعن فيها 
              </span>
            </div>
            
            <!-- space -->
            <div class="spacer"></div>

            <!-- second level judgements -->
            <div>
              <span v-if="late_judgements.length">
                  <button class="btn btn-sm btn-success pull-left" data-toggle="collapse" data-target="#late_judgements"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                    <cevil-judgements-table :header="'احكام الدرجة الثانية المدنية والتجارية الصادرة منذ اقل من 70 يوما ولم يتم الطعن فيها '" :id="'late_judgements'" :data="late_judgements"></cevil-judgements-table>
              </span>
              <span v-else class="alert alert-info heading print-hidden col-xs-12">
                لا توجد احكام الدرجة الثانية المدنية والتجارية الصادرة منذ اقل من 70 يوما ولم يتم الطعن فيها 
              </span>
            </div>

        </div>
        

        
      </div>
      <div class="spacer"></div>
@endsection


@section('js')

<script src="{{ URL::asset('js/mainPage.js') }}"></script>
@endsection