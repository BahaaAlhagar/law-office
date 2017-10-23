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

      </div>
@endsection


@section('js')

<script src="{{ URL::asset('js/listMeetings.js') }}"></script>
@endsection