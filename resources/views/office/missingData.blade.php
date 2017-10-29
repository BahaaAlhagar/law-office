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

      <div id="missingData">
        
        <div class="heading col-xs-12">
           تحتوى هذه الصفحة على القضايا التى تحتاج الى بعض البيانات لاستكمالها
           <button class="btn pull-left btn-success" @click="printPage">طباعة الصفحة</button>
        </div><br>


        <!-- space -->
        <div class="spacer"></div>

        
        <div>
          <span v-if="issue_numbers.length">
              <button class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#issue_numbers"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                <issue-numbers-table :header="'قضايا لم يتم استيفاء ارقامها الجزئية'" :id="'issue_numbers'" :data="issue_numbers"></issue-numbers-table>
          </span>
          <span v-else class="alert alert-info heading col-xs-12">
            لا توجد قضايا لم يتم استيفاء ارقامها الجزئية
          </span>
        </div>
        
        <!-- space -->
        <div class="spacer"></div>

        
        <div>
          <span v-if="issue_adv_numbers.length">
              <button class="btn btn-sm btn-success pull-left" data-toggle="collapse" data-target="#issue_adv_numbers"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                <issue-adv-numbers-table :header="'قضايا لم يتم استيفاء ارقامها الاستئنافية بعد'" :id="'issue_adv_numbers'" :data="issue_adv_numbers"></issue-adv-numbers-table>
          </span>
          <span v-else class="alert alert-info heading col-xs-12">
            لا توجد قضايا لم يتم استيفاء ارقامها الاستئنافية بعد
          </span>
        </div>


        <!-- space -->
        <div class="spacer"></div>

        
        <div>
          <span v-if="dates.length">
              <button class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#dates"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                <issue-adv-numbers-table :header="'قضايا لم تحدد بها اكثر من خصم او جلسات حتى الان'" :id="'dates'" :data="dates"></issue-adv-numbers-table>
          </span>
          <span v-else class="alert alert-info heading col-xs-12">
            لا توجد قضايا لم تحدد بها اكثر من خصم او جلسات حتى الان
          </span>
        </div>

        
      </div>
      <div class="spacer"></div>
@endsection


@section('js')

<script src="{{ URL::asset('js/missingData.js') }}"></script>
@endsection