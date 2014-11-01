@extends('layouts.master')

@section('title')
	Search Results
@stop

@section('content')
	<h1>Search Results <small>"{{ $term }}", {{ $results->getTotal() }} results</small></h1>

	{{ Form::open(['route' => 'search.do', 'method' => 'GET']) }}
		<div class="row">
			<div class="col-md-5">
				<div class="form-group">
					{{ Form::text('q', null, ['placeholder' => 'Search Xtras', 'class' => 'form-control input-lg']) }}
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					{{ Form::button('Search', ['class' => 'btn btn-lg btn-block btn-primary', 'type' => 'submit']) }}
				</div>
			</div>
			<div class="col-md-3">
				<a href="{{ route('search.advanced') }}" class="btn btn-lg btn-link">Advanced Search</a>
			</div>
		</div>
	{{ Form::close() }}

	@if ($results->getTotal() > 0)
		{{ $results->appends(Input::except(['page']))->links() }}

		<div class="data-table data-table-bordered data-table-striped">
		@foreach ($results as $item)
			<div class="row">
				<div class="col-md-9">
					<p class="lead">{{ $item->present()->name }}</p>
					<p>
						{{ $item->present()->productAsLabel }}
						{{ $item->present()->typeAsLabel }}
					</p>
					<div class="text-sm text-muted">{{ $item->present()->description }}</div>
				</div>
				<div class="col-md-3">
					<div class="btn-toolbar pull-right">
						@if (Auth::check() and $_currentUser->can('xtras.admin'))
							<div class="btn-group">
								<a href="{{ route('item.edit', [$item->user->username, $item->slug, 'admin']) }}" class="btn btn-default">Edit</a>
							</div>
						@endif

						<div class="btn-group">
							<a href="{{ route('item.show', [$item->user->username, $item->slug]) }}" class="btn btn-default">View</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>

		{{ $results->appends(Input::except(['page']))->links() }}
	@else
		{{ alert('warning', "No Xtras found with the term \"".$term."\". Please try another search term.") }}
	@endif
@stop