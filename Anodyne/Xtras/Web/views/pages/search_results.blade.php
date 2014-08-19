@extends('layouts.master')

@section('title')
	Search Results
@stop

@section('content')
	<h1>Search Results <small>"{{ $term }}", {{ $results->getTotal() }} results</small></h1>

	<div class="row">
		<div class="col-md-5 col-lg-5">
			{{ Form::open(['route' => 'search.do', 'method' => 'GET']) }}
				<div class="form-group">
					<div class="input-group">
						{{ Form::text('q', null, array('placeholder' => 'Search Xtras', 'class' => 'form-control')) }}
						<span class="input-group-btn">{{ Form::button('Search', array('class' => 'btn btn-default', 'type' => 'submit')) }}</span>
					</div>
				</div>
			{{ Form::close() }}
		</div>
		<div class="col-md-3 col-lg-3">
			<a href="{{ route('search.advanced') }}" class="btn btn-link">Advanced Search</a>
		</div>
	</div>

	@if ($results->getTotal() > 0)
		{{ $results->appends(Input::except(['page']))->links() }}

		<div class="data-table data-table-bordered data-table-striped">
		@foreach ($results as $item)
			<div class="row">
				<div class="col-md-9 col-lg-9">
					<p class="lead">{{ $item->present()->name }}</p>
					{{ $item->present()->productAsLabel }}
					{{ $item->present()->typeAsLabel }}
					<div class="text-sm text-muted">{{ $item->present()->description }}</div>
				</div>
				<div class="col-md-3 col-lg-3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="{{ route('item.show', [$item->user->slug, $item->slug]) }}" class="btn btn-default">{{ $_icons['next'] }}</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>

		{{ $results->appends(Input::except(['page']))->links() }}
	@else
		<p class="alert alert-warning">No xtras found with the term "{{ $term }}". Please try another search term.</p>
	@endif
@stop