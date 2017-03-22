@extends('layouts.master')

@section('title')
	My Xtras
@stop

@section('content')
	<h1>My Xtras</h1>

	@if (count($xtras) == 0)
		@if ($_currentUser->can('xtras.item.create') or $_currentUser->can('xtras.admin'))
			<div class="row">
				<div class="col-md-4 visible-md visible-lg">
					<p><a href="{{ route('item.create') }}" class="btn btn-block btn-lg btn-primary">Create Your First Xtra</a></p>
				</div>
				<div class="col-md-4">
					<p><a href="{{ route('getting-started') }}" class="btn btn-block btn-lg btn-primary">Getting Started</a></p>
				</div>
				<div class="col-md-4">
					<p><a href="#" class="btn btn-block btn-lg btn-primary js-contact">Get Help</a></p>
				</div>
			</div>
		@else
			{{ alert('warning', "You don't have any Xtras. Your account currently doesn't allow you to create Xtras. If you believe this was done in error, please <a href='#' class='js-contact'>contact</a> Anodyne Productions.") }}
		@endif
	@else
		@if ($_currentUser->can('xtras.item.create') or $_currentUser->can('xtras.admin'))
			<div class="btn-toolbar visible-md visible-lg">
				<div class="btn-group">
					<a href="{{ route('item.create') }}" class="btn btn-primary">Create New Xtra</a>
				</div>
			</div>
		@endif

		<ul class="nav nav-tabs">
			<li class="active"><a href="#skins" data-toggle="tab">Skins</a></li>
			<li><a href="#mods" data-toggle="tab">MODs</a></li>
			<li><a href="#ranks" data-toggle="tab">Rank Sets</a></li>
			<li><a href="#usage" data-toggle="tab">My Usage</a></li>
		</ul>

		<div class="tab-content">
			<div id="skins" class="active tab-pane">
				@if (array_key_exists('Skin', $xtras))
					@foreach ($xtras['Skin'] as $product => $items)
						<h2>{{ $product }}</h2>
						{{ partial('my-xtras-row', ['items' => $items]) }}
					@endforeach
				@else
					{{ alert('warning', "You don't have any skins.") }}
				@endif
			</div>

			<div id="mods" class="tab-pane">
				@if (array_key_exists('MOD', $xtras))
					@foreach ($xtras['MOD'] as $product => $items)
						<h2>{{ $product }}</h2>
						{{ partial('my-xtras-row', ['items' => $items]) }}
					@endforeach
				@else
					{{ alert('warning', "You don't have any MODs.") }}
				@endif
			</div>

			<div id="ranks" class="tab-pane">
				@if (array_key_exists('Rank Set', $xtras))
					@foreach ($xtras['Rank Set'] as $product => $items)
						<h2>{{ $product }}</h2>
						{{ partial('my-xtras-row', ['items' => $items]) }}
					@endforeach
				@else
					{{ alert('warning', "You don't have any rank sets.") }}
				@endif
			</div>

			<div id="usage" class="tab-pane">
				<h2>My Usage</h2>

				<div class="row">
					<div class="col-md-5">
						<canvas id="xtraUsage" width="400" height="400"></canvas>
					</div>
					<div class="col-md-7">
						<p>{{ label('info label-lg', $usage['Skin']['label'].': '.$usage['Skin']['prettySize']) }}</p>
						<p>{{ label('danger label-lg', $usage['MOD']['label'].': '.$usage['MOD']['prettySize']) }}</p>
						<p>{{ label('success label-lg', $usage['Rank Set']['label'].': '.$usage['Rank Set']['prettySize']) }}</p>

						@if ($usage['Skin']['value'] + $usage['MOD']['value'] + $usage['Rank Set']['value'] > Config::get('anodyne.usageWarning'))
							{{ alert('warning', "You're currently using over 250mb of space on the server and are in danger of having your account suspended. Please contact Anodyne Productions to correct this issue.") }}
						@endif
					</div>
				</div>
			</div>
		</div>
	@endif
@stop

@section('modals')
	{{ modal(['id' => 'removeItem', 'header' => 'Remove Xtra']) }}
@stop

@section('scripts')
	{{ partial('js/item-remove') }}
	{{ HTML::script('js/Chart.min.js') }}
	<script>
		var ctx = document.getElementById("xtraUsage").getContext("2d");
		
		new Chart(ctx).Doughnut({{ json_encode($usage) }}, {
			segmentStrokeColor: "#fbfbfb",
			segmentStrokeWidth : 5,
			animateScale: true,
			showTooltips: false
		});
	</script>
@stop