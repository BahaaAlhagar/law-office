@extends('layouts/master')

@section('meta')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    القضية رقم {{ $issue->number }} لسنة {{ $issue->year }}
@endsection

@section('css')
    <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
@endsection

@section('content')

      <div id="issueProfile">
        <!-- Issue info -->
        <issue-info :issue="issue" :people="people"></issue-info>
        
      </div>
@endsection


@section('js')

<script src="{{ URL::asset('js/issueProfile.js') }}"></script>
@endsection