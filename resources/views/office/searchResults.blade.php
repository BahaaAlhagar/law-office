@extends('layouts/master')


@section('title')

- نتائج البحث

@endsection



@section('content')


@if(!count($people)  && !count($issues) && !count($contracts) && !count($judgements))

	<div class="card mr-auto">
        <div class="card-header">
          	<h4 class="card-title green">نتائج البحث</h4>
        </div>
        <div class="panel-body text-center">
          	<b>لا يوجد نتائج لبحثك.</b>
        </div>
	</div>
@else


<div id="search_panel" class="panel panel-primary">

	<div class="card mr-auto">
        <div class="card-header">
          	<h4 class="card-title green">نتائج البحث</h4>
        </div>
        <div class="panel-body text-center">

        	<!-- people table -->
        	@if (count($people))
				<table class="table table-striped table-bordered table-responsive">
					<thead class="thead-inverse">
						<tr>
							<th float="right">
							اســم المـوكـــل
							</th>
							<th>
							مــحل الاقــامــة
							</th>
							<th>
							رقــم التــليفــون
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach($people as $person)
						<tr>
							<td>
								<a href="{{ route('people.show', $person->id) }}" target="_blank">
									{{ $person->name }}
								</a>
							</td>
							<td>{{ $person->location }}</td>
							<td>
								@if($person->phone)
									{{ $person->phone }}
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			@endif


			<!-- issues table -->
        	@if (count($issues))
				<table class="table table-striped table-bordered table-responsive">
					<thead class="thead-inverse">
						<tr>
							<th float="right">
							رقم القضية
							</th>
							<th>
							الموضوع
							</th>
							<th>
							الخصوم
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach($issues as $issue)
						<tr>
							<td>
								<a href="{{ route('issues.show', $issue->id) }}" target="_blank">
									{{ $issue->number }} لسنة {{ $issue->year }}<br>
									{{ $issue->adv_number }} لسنة {{ $issue->adv_year }} س
								</a>
							</td>
							<td>
								<a href="{{ route('issues.show', $issue->id) }}" target="_blank">
									{{ $issue->subject }}
								</a>
							</td>
							<td>
								@foreach($issue->openents as $openent)
									{{ $openent->name }}<br>
								@endforeach
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			@endif


			<!-- contracts table -->
        	@if (count($contracts))
				<table class="table table-striped table-bordered table-responsive">
					<thead class="thead-inverse">
						<tr>
							<th float="right">
							رقم التوكيل
							</th>
							<th>
							جهة الاصار
							</th>
							<th>
							الموكلين
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach($contracts as $contract)
						<tr>
							<td>
								<a href="{{ route('contracts.show', $contract->id) }}" target="_blank">
									{{ $contract->number }} لسنة {{ $contract->year }}
								</a>
							</td>
							<td>
								<a href="{{ route('contracts.show', $contract->id) }}" target="_blank">
									{{ $contract->office }}
								</a>
							</td>
							<td>
								@foreach($contract->people as $person)
									{{ $person->name }}<br>
								@endforeach
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			@endif


			<!-- judgements table -->
        	@if (count($judgements))
				<table class="table table-striped table-bordered table-responsive">
					<thead class="thead-inverse">
						<tr>
							<th float="right">
							رقم الحصر
							</th>
							<th>
							الحكم و تاريخه
							</th>
							<th>
							المتهم
							</th>
						</tr>
					</thead>
					<tbody>
						@foreach($judgements as $judgement)
						<tr>
							<td>
								<a href="{{ route('issues.show', $judgement->issue->id) }}" target="_blank">
									{{ $judgement->record }} لسنة {{ $judgement->year }}
								</a>
							</td>
							<td>
								<a href="{{ route('issues.show', $judgement->issue->id) }}" target="_blank">
									{{ $judgement->body }} <br> {{ $judgement->date }}
								</a>
							</td>
							<td>
								{{ $judgement->person->name }}<br>							
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			@endif


		</div>
	</div>

@endif


@endsection