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
        <!-- Meetings List -->
        <div class="col-xs-12">
        	قضايا واحكام : 
	        <a href="{{ route('people.show', $person->id) }}">
	        	{{ $person->name }}
	        </a>
           <button class="btn pull-left btn-success" @click="printPage">طباعة الصفحة</button>
        </div>
      </div>
@endsection


@section('js')

<script src="{{ URL::asset('js/personIssues.js') }}"></script>
@endsection