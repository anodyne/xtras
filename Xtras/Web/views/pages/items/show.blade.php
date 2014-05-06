@extends('layouts.master')

@section('title')
	{{ $item->present()->name }}
@stop

@section('content')
	<h1>{{ $item->present()->name }} <small>{{ $item->present()->type }}</small></h1>

	<h4>by {{ $item->present()->author }}</h4>

	<div>{{ $item->present()->description }}</div>

	<p>{{ $item->present()->downloadBtn }}</p>

	<div class="row">
		<div class="col-lg-9">
			<h2>Details</h2>

			<dl>
				<dt>Author</dt>
				<dd>{{ $item->present()->author }}</dd>

				<dt>Downloads</dt>
				<dd>{{ $item->present()->downloads }}</dd>

				@if ($item->present()->rating !== false)
					<dt>Rating</dt>
					<dd>{{ $item->present()->rating }}</dd>
				@endif

				<dt>Added</dt>
				<dd>{{ $item->present()->created }}</dd>

				@if ($item->present()->created != $item->present()->updated)
					<dt>Last Updated</dt>
					<dd>{{ $item->present()->updated }}</dd>
				@endif
			</dl>

			<div class="btn-toolbar">
				<div class="btn-group">
					<a href="#" class="btn btn-default">Report an Issue</a>
				</div>
				<div class="btn-group">
					<a href="#" class="btn btn-default">Report Abuse to Anodyne</a>
				</div>
			</div>

			@if ($item->meta and ! empty($item->meta->installation))
				<h2>Installation</h2>

				{{ $item->meta->present()->installation }}
			@endif

			<h2>Version History</h2>

			<h2>Downloads</h2>

			@if ($item->comments->count() > 0)
				<h2>Comments</h2>
			@endif
		</div>

		<div class="col-lg-3">
			<p><img src="http://placehold.it/250x250"></p>
			<p><img src="http://placehold.it/250x250"></p>
			<p><img src="http://placehold.it/250x250"></p>
		</div>
	</div>
@stop