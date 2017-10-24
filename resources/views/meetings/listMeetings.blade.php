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

      <div id="listMeetings">
        <!-- Meetings List -->
        <div class="heading col-xs-12">
           يمكنك عرض الجلسات سواء سابقة او حالية من خلال هذه الصفحة
           <button class="btn pull-left btn-success" @click="printPage">طباعة الصفحة</button>
        </div><br>
        <div class="heading col-xs-12" style="font-size: 10px;">
            <form method="post" @submit.prevent="listDates()" action="/meetings/list" class="form-inline">
              <div class="form-group">
                <label for="start">عــرض الـجلـســات من </label>
                <flat-pickr v-model="start" 
                            name="start" 
                            :config="config" 
                            placeholder="اختر تاريخ البداية">
                            </flat-pickr>
                <label for="end">حــتــى</label>
                <flat-pickr v-model="end" 
                            name="end" 
                            :config="config" 
                            placeholder="اختر تاريخ النهاية">
                            </flat-pickr>
                <button class="btn btn-primary" type="submit">اعرض الجلسات</button>
              </div>
            </form>
        </div>

        <div v-if="showDefault">
            <span v-if="thisweekcevil.length">
            	<button class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#thisweekcevil"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
            	<meetings-table :header="'الجلسات المدنية والتجارية والادارية لهذا الاسبوع'" :id="'thisweekcevil'" :data="thisweekcevil"></meetings-table>
            </span>
            <span v-else class="alert alert-info heading col-xs-12">
            	لا يوجد جلسات مدنية او تجارية لهذا الاسبوع
            </span>

            <span v-if="thisweekcriminal.length">
            	<button class="btn btn-sm btn-dark pull-left" data-toggle="collapse" data-target="#thisweekcriminal"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
            	<meetings-table :header="'الجلسات الجنائية لهذا الاسبوع'" :id="'thisweekcriminal'" :data="thisweekcriminal"></meetings-table>
            </span>
            <span v-else class="alert alert-info heading col-xs-12">
            	لا يوجد جلسات جنائية لهذا الاسبوع
            </span>

            <span v-if="nextweekcevil.length">
            	<button class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#nextweekcevil"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
            	<meetings-table :header="'الجلسات المدنية والتجارية والادارية للاسبوع القادم'" :id="'nextweekcevil'" :data="nextweekcevil"></meetings-table>
            </span>
            <span v-else class="alert alert-info heading col-xs-12">
            	لا يوجد جلسات مدنية او تجارية للاسبوع القادم
            </span>

            <span v-if="nextweekcriminal.length">
            	<button class="btn btn-sm btn-dark pull-left" data-toggle="collapse" data-target="#nextweekcriminal"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
            	<meetings-table :header="'الجلسات الجنائية للاسبوع القادم'" :id="'nextweekcriminal'" :data="nextweekcriminal"></meetings-table>
            </span>
            <span v-else class="alert alert-info heading col-xs-12">
            	لا يوجد جلسات جنائية للاسبوع القادم
            </span>
        </div>

        <div v-if="!showDefault">
            <span v-if="cevil.length">
                <button class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#cevil"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                <meetings-table :header="'الجلسات المدنية والتجارية والادارية من ' + dayFromat(start) + ' حتى ' + dayFromat(end)" :id="'cevil'" :data="cevil"></meetings-table>
            </span>
            <span v-else class="alert alert-info heading col-xs-12">
                لا يوجد جلسات مدنية او تجارية فى هذه الفترة
            </span>

            <span v-if="criminal.length">
                <button class="btn btn-sm btn-dark pull-left" data-toggle="collapse" data-target="#criminal"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
                <meetings-table :header="'الجلسات الجنائية من ' + dayFromat(start) + ' حتى ' + dayFromat(end)" :id="'criminal'" :data="criminal"></meetings-table>
            </span>
            <span v-else class="alert alert-info heading col-xs-12">
                لا يوجد جلسات جنائية فى هذه الفترة
            </span>
        </div>

      </div>
@endsection


@section('js')

<script src="{{ URL::asset('js/listMeetings.js') }}"></script>
@endsection