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

      <div id="expirationPage">
        
        <div class="heading col-xs-12">
           تحتوى هذه الصفحة على القضايا التى تحتاج الى بعض البيانات لاستكمالها
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
            <div>
              <span v-if="not_present_judgements.length">
                  <button class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#not_present_judgements"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                    <not-present-table :header="'احكام مدنية غيابية لم تعلن بعد'" :id="'not_present_judgements'" :data="not_present_judgements"></not-present-table>
              </span>
              <span v-else class="alert alert-info heading col-xs-12">
                لا توجد احكام مدنية غيابية لم تعلن بعد
              </span>
            </div>
            
            <!-- space -->
            <div class="spacer"></div>

            
            

        </div>
        

        
      </div>
      <div class="spacer"></div>
@endsection


@section('js')

<script src="{{ URL::asset('js/expirationPage.js') }}"></script>
@endsection