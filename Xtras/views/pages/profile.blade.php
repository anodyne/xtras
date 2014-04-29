@extends('layouts.master')

@section('title')
	{{ $user->present()->name }}
@stop

@section('content')
	<h1>{{ $user->present()->name }}</h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			{{ $user->present()->siteBtn }}
		</div>

		@if ($user->id == $_currentUser->id)
			<div class="btn-group">
				<a href="#" class="btn btn-default">Edit My Account</a>
			</div>
		@endif
	</div>

	{{ $user->present()->bio }}

	@if ($user->items->count() > 0)
		<h2>Xtras</h2>

		@if ($user->present()->itemsSkins->count() > 0)
			<h3>Skins</h3>

			<div class="row">
			@foreach ($user->present()->itemsSkins as $item)
				<div class="col-lg-6">
					{{ View::make('partials.media')->withItem($item) }}<br>
				</div>
			@endforeach
			</div>
		@endif

		@if ($user->present()->itemsRanks->count() > 0)
			<h3>Rank Sets</h3>

			<div class="row">
			@foreach ($user->present()->itemsRanks as $item)
				<div class="col-lg-6">
					{{ View::make('partials.media')->withItem($item) }}<br>
				</div>
			@endforeach
			</div>
		@endif

		@if ($user->present()->itemsMods->count() > 0)
			<h3>MODs</h3>

			<div class="row">
			@foreach ($user->present()->itemsMods as $item)
				<div class="col-lg-6">
					{{ View::make('partials.media')->withItem($item) }}<br>
				</div>
			@endforeach
			</div>
		@endif
	@endif
@stop