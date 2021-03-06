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
        <issue-info :issue="issue"></issue-info>
        
        <issue-openents :issue="issue" :people="people" :openents="openents"></issue-openents>

        <issue-files :issue="issue" :files="files"></issue-files>

        <issue-meetings :meetings="meetings" :issue="issue" :accusedopenents="accusedopenents"></issue-meetings>
        
      </div>
@endsection


@section('js')

<script src="{{ URL::asset('js/issueProfile.js') }}"></script>
@endsection