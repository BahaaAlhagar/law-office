@extends('layouts/master')


@section('title', 'ادارة الاشخاص')

@section('content')

<div id="managePeople">
	

	@foreach($people as $person)
		{{$person->name}}
	@endforeach
</div>

@endsection

@section('js')
	<script src="{{ URL::asset('js/managePeople.js') }}"></script>
@endsection
