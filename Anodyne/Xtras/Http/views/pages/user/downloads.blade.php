@extends('layouts.master')

@section('title')
	My Downloads
@stop

@section('content')
	<h1>My Downloads</h1>

	@if ($orders->count() > 0)
		<div class="data-table data-table-bordered data-table-striped">
		@foreach ($orders as $o)
			<div class="row">
				<div class="col-md-6">
					<p class="lead">{{ $o->item->present()->nameWithVersion }}</p>
				</div>
				<div class="col-md-3">
					<p class="text-muted">{{ $o->present()->downloaded }}</p>
				</div>
				<div class="col-md-3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="{{ route('item.show', [$o->item->user->username, $o->item->slug]) }}" class="btn btn-default">View</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@else
		{{ alert('warning', "You don't have any downloads.") }}
	@endif
@stop