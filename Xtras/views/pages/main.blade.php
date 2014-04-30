@extends('layouts.master')

@section('title')
	Home
@stop

@section('content')
	<h1>Welcome to AnodyneXtras</h1>

	<div class="row">
		<div class="col-md-6 col-lg-6">
			<h2>Newest Xtras</h2>

			@foreach ($new as $item)
				{{ View::make('partials.media')->withItem($item) }}
			@endforeach
		</div>

		<div class="col-md-6 col-lg-6">
			<h2>Recently Updated Xtras</h2>

			@foreach ($updated as $item)
				{{ View::make('partials.media')->withItem($item) }}
			@endforeach
		</div>
	</div>
@stop