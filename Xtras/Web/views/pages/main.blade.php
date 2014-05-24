@extends('layouts.master')

@section('title')
	Home
@stop

@section('content')
	<div id="newest">
		<a href="#" class="btn btn-sm btn-default pull-right">See Recently Updated Xtras</a>

		<h2>Newest Xtras</h2>

		<div class="row">
			@foreach ($new as $item)
				<div class="col-sm-6 col-md-6 col-lg-4">
					{{ View::make('partials.media')->withItem($item) }}
				</div>
			@endforeach
		</div>
	</div>
	
	<div id="updated">
		<a href="#" class="btn btn-sm btn-default pull-right">See Newest Xtras</a>

		<h2>Recently Updated Xtras</h2>

		<div class="row">
			@foreach ($updated as $item)
				<div class="col-sm-6 col-md-6 col-lg-4">
					{{ View::make('partials.media')->withItem($item) }}
				</div>
			@endforeach
		</div>
	</div>
@stop