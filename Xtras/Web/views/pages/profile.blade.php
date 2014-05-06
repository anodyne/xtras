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

		<ul class="nav nav-pills">
			<li class="active"><a href="#skins" data-toggle="pill">Skins</a></li>
			<li><a href="#mods" data-toggle="pill">MODs</a></li>
			<li><a href="#ranks" data-toggle="pill">Rank Sets</a></li>
		</ul>

		<div class="tab-content">
			<div id="skins" class="active tab-pane">
				@if ($user->present()->itemsSkins->count() > 0)
					<div class="row">
					@foreach ($user->present()->itemsSkins as $item)
						<div class="col-lg-6">
							{{ View::make('partials.media')->withItem($item) }}<br>
						</div>
					@endforeach
					</div>
				@endif
			</div>

			<div id="mods" class="tab-pane">
				@if ($user->present()->itemsMods->count() > 0)
					<div class="row">
					@foreach ($user->present()->itemsMods as $item)
						<div class="col-lg-6">
							{{ View::make('partials.media')->withItem($item) }}<br>
						</div>
					@endforeach
					</div>
				@endif
			</div>

			<div id="ranks" class="tab-pane">
				@if ($user->present()->itemsRanks->count() > 0)
					<div class="row">
					@foreach ($user->present()->itemsRanks as $item)
						<div class="col-lg-6">
							{{ View::make('partials.media')->withItem($item) }}<br>
						</div>
					@endforeach
					</div>
				@endif
			</div>
		</div>
	@endif
@stop