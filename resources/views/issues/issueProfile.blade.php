@extends('layouts/master')



@section('title')
    القضية رقم {{ $issue->number }} لسنة {{ $issue->year }}
@endsection

@section('css')
    <link href="{{ URL::asset('css/toastr.min.css') }}" rel="stylesheet">
@endsection

@section('content')

      <div id="issueProfile">
        <!-- Issue info -->
        <issue-info></issue-info>
        
      </div>
@endsection


@section('js')

<script src="{{ URL::asset('js/issueProfile.js') }}"></script>
@endsection