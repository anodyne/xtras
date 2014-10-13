@extends('layouts.master')

@section('title')
	My Xtras
@stop

@section('content')
	<h1>My Xtras</h1>

	@if ($_currentUser->can('xtras.item.create') or $_currentUser->can('xtras.admin'))
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('item.create') }}" class="btn btn-primary">Create New Xtra</a>
			</div>
		</div>
	@endif

	@if (count($xtras) == 0)
		@if ($_currentUser->can('xtras.items.create') or $_currentUser->can('xtras.admin'))
			{{ alert('warning', "It looks like you don't have any Xtras. Go ahead and change that, ".link_to_route('item.create', 'create your first')."!") }}
		@else
			{{ alert('warning', "You don't have any Xtras. Your account currently doesn't allow you to create Xtras. If you believe this was done in error, please <a href='#' class='js-contact'>contact</a> Anodyne Productions.") }}
		@endif
	@else
		<ul class="nav nav-tabs">
			<li class="active"><a href="#skins" data-toggle="tab">Skins</a></li>
			<li><a href="#mods" data-toggle="tab">MODs</a></li>
			<li><a href="#ranks" data-toggle="tab">Rank Sets</a></li>
		</ul>

		<div class="tab-content">
			<div id="skins" class="active tab-pane">
				@if (array_key_exists('Skin', $xtras))
					@foreach ($xtras['Skin'] as $product => $items)
						<h2>{{ $product }}</h2>
						{{ partial('my-xtras-row', ['items' => $items]) }}
					@endforeach
				@else
					<p class="alert alert-warning">You don't have any skins.</p>
				@endif
			</div>

			<div id="mods" class="tab-pane">
				@if (array_key_exists('MOD', $xtras))
					@foreach ($xtras['MOD'] as $product => $items)
						<h2>{{ $product }}</h2>
						{{ partial('my-xtras-row', ['items' => $items]) }}
					@endforeach
				@else
					<p class="alert alert-warning">You don't have any MODs.</p>
				@endif
			</div>

			<div id="ranks" class="tab-pane">
				@if (array_key_exists('Rank Set', $xtras))
					@foreach ($xtras['Rank Set'] as $product => $items)
						<h2>{{ $product }}</h2>
						{{ partial('my-xtras-row', ['items' => $items]) }}
					@endforeach
				@else
					<p class="alert alert-warning">You don't have any rank sets.</p>
				@endif
			</div>
		</div>
	@endif
@stop

@section('modals')
	{{ modal(['id' => 'removeItem', 'header' => 'Remove Xtra']) }}
@stop

@section('scripts')
	{{ partial('js/item-remove') }}
@stop