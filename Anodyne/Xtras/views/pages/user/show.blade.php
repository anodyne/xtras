@extends('layouts.master')

@section('title')
	{{ $user->present()->name }}
@stop

@section('content')
	{{ $user->present()->avatar(['type' => false, 'class' => 'avatar img-circle pull-right']) }}

	<h1>{{ $user->present()->name }}</h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			{{ $user->present()->siteBtn }}
		</div>

		<div class="btn-group">
			{{ $user->present()->twitterBtn() }}
			{{ $user->present()->facebookBtn() }}
			{{ $user->present()->googleBtn() }}
		</div>
	</div>

	{{ $user->present()->bio }}

	@if ($user->items->count() > 0)
		<h2>Xtras</h2>

		<ul class="nav nav-pills">
			<li class="active"><a href="#skins" data-toggle="pill">Skins
				@if ($user->present()->itemsSkins->count() > 0)
					({{ $user->present()->itemsSkins->count() }})
				@endif
			</a></li>
			<li><a href="#mods" data-toggle="pill">MODs
				@if ($user->present()->itemsMods->count() > 0)
					({{ $user->present()->itemsMods->count() }})
				@endif
			</a></li>
			<li><a href="#ranks" data-toggle="pill">Rank Sets
				@if ($user->present()->itemsRanks->count() > 0)
					({{ $user->present()->itemsRanks->count() }})
				@endif
			</a></li>
		</ul>

		<div class="tab-content">
			<div id="skins" class="active tab-pane">
				@if ($user->present()->itemsSkins->count() > 0)
					<div class="row">
					@foreach ($user->present()->itemsSkins as $item)
						<div class="col-md-4">
							{{ View::make('partials.media')->withItem($item) }}<br>
						</div>
					@endforeach
					</div>
				@else
					{{ alert('warning', $user->present()->name." doesn't have any skins.") }}
				@endif
			</div>

			<div id="mods" class="tab-pane">
				@if ($user->present()->itemsMods->count() > 0)
					<div class="row">
					@foreach ($user->present()->itemsMods as $item)
						<div class="col-md-4">
							{{ View::make('partials.media')->withItem($item) }}<br>
						</div>
					@endforeach
					</div>
				@else
					{{ alert('warning', $user->present()->name." doesn't have any MODs.") }}
				@endif
			</div>

			<div id="ranks" class="tab-pane">
				@if ($user->present()->itemsRanks->count() > 0)
					<div class="row">
					@foreach ($user->present()->itemsRanks as $item)
						<div class="col-md-4">
							{{ View::make('partials.media')->withItem($item) }}<br>
						</div>
					@endforeach
					</div>
				@else
					{{ alert('warning', $user->present()->name." doesn't have any rank sets.") }}
				@endif
			</div>
		</div>
	@else
		{{ alert('warning', $user->present()->name." doesn't have any Xtras yet.") }}
	@endif
@stop