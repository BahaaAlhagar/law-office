@extends('layouts/master')

@section('meta')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    قضايا واحكام - {{ $person->name }}
@endsection

@section('css')
    <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
@endsection

@section('content')

      <div id="personIssues">
        <!-- person Issues -->
        <div class="col-xs-12">
        	قضايا واحكام : 
	        <a href="{{ route('people.show', $person->id) }}">
	        	{{ $person->name }}
	        </a>
           <button class="btn pull-left btn-success" @click="printPage">طباعة الصفحة</button>
        </div>

        <div>
            <span v-if="cevil_issues.length">
              <button class="btn btn-sm btn-info pull-left" data-toggle="collapse" data-target="#cevil_issues"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
              <issues-table :header="'القضايا المدنية والتجارية'" :id="'cevil_issues'" :data="cevil_issues"></issues-table>
            </span>
            <span v-else class="alert alert-info heading col-xs-12">
              لا يوجد قضايا مدنية او تجارية لهذا الشخص
            </span>
        </div>

        <div>
            <span v-if="criminal_issues.length">
              <button class="btn btn-sm btn-dark pull-left" data-toggle="collapse" data-target="#criminal_issues"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
              <issues-table :header="'القضايا الجنائية'" :id="'criminal_issues'" :data="criminal_issues"></issues-table>
            </span>
            <span v-else class="alert alert-info heading col-xs-12">
              لا يوجد قضايا جنائية لهذا الشخص
            </span>
        </div>

        <div>
            <span v-if="excutive_issues.length">
              <button class="btn btn-sm btn-success pull-left" data-toggle="collapse" data-target="#excutive_issues"><i class="fa fa-window-minimize" aria-hidden="true"></i></button>
              <excutive-issue-table :header="'القضايا الادارية'" :id="'excutive_issues'" :data="excutive_issues"></excutive-issue-table>
            </span>
            <span v-else class="alert alert-info heading col-xs-12">
              لا يوجد قضايا ادارية لهذا الشخص
            </span>
        </div>

      </div>
@endsection


@section('js')

<script src="{{ URL::asset('js/personIssues.js') }}"></script>
@endsection