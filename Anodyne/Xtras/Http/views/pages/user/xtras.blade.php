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
		{{ alert('warning', "It looks like you don't have any Xtras. Go ahead and change that, ".link_to_route('item.create', 'create your first')."!") }}
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
						<div class="data-table data-table-striped data-table-bordered">
						@foreach ($items as $item)
							<div class="row {{ $item->product->present()->nameAsSlug }}">
								<div class="col-md-6">
									<p class="lead">{{ $item->present()->nameWithVersion }}</p>
									{{ $item->present()->disabledLabel }}
									{{ $item->present()->adminDisabledLabel }}
								</div>
								<div class="col-md-6">
									<div class="btn-toolbar pull-right">
										<div class="btn-group">
											<a href="{{ route('item.show', [$item->user->username, $item->slug]) }}" class="btn btn-default">View</a>
										</div>
										
										@if ($_currentUser->can('xtras.item.edit'))
											<div class="btn-group">
												<a href="{{ route('item.edit', [$item->user->username, $item->slug]) }}" class="btn btn-default">Edit</a>
											</div>
											<div class="btn-group">
												<a href="{{ route('item.messages.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Messages</a>
												<a href="{{ route('item.files.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Files</a>
												<a href="{{ route('item.images.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Images</a>
											</div>
										@endif

										@if ($_currentUser->can('xtras.item.delete'))
											<div class="btn-group">
												<a href="#" class="btn btn-danger js-remove-item" data-id="{{ $item->id }}">Remove</a>
											</div>
										@endif
									</div>
								</div>
							</div>
						@endforeach
						</div>
					@endforeach
				@else
					{{ alert('warning', "You don't have any skins.") }}
				@endif
			</div>

			<div id="mods" class="tab-pane">
				@if (array_key_exists('MOD', $xtras))
					@foreach ($xtras['MOD'] as $product => $items)
						<h2>{{ $product }}</h2>
						<div class="data-table data-table-striped data-table-bordered">
						@foreach ($items as $item)
							<div class="row">
								<div class="col-md-6">
									<p class="lead">{{ $item->present()->nameWithVersion }}</p>
									{{ $item->present()->disabledLabel }}
									{{ $item->present()->adminDisabledLabel }}
								</div>
								<div class="col-md-6">
									<div class="btn-toolbar pull-right">
										<div class="btn-group">
											<a href="{{ route('item.show', [$item->user->username, $item->slug]) }}" class="btn btn-default">View</a>
										</div>

										@if ($_currentUser->can('xtras.item.edit'))
											<div class="btn-group">
												<a href="{{ route('item.edit', [$item->user->username, $item->slug]) }}" class="btn btn-default">Edit</a>
											</div>
											<div class="btn-group">
												<a href="{{ route('item.messages.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Messages</a>
												<a href="{{ route('item.files.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Files</a>
												<a href="{{ route('item.images.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Images</a>
											</div>
										@endif

										@if ($_currentUser->can('xtras.item.delete'))
											<div class="btn-group">
												<a href="#" class="btn btn-danger js-remove-item" data-id="{{ $item->id }}">Remove</a>
											</div>
										@endif
									</div>
								</div>
							</div>
						@endforeach
						</div>
					@endforeach
				@else
					{{ alert('warning', "You don't have any MODs.") }}
				@endif
			</div>

			<div id="ranks" class="tab-pane">
				@if (array_key_exists('Rank Set', $xtras))
					@foreach ($xtras['Rank Set'] as $product => $items)
						<h2>{{ $product }}</h2>
						<div class="data-table data-table-striped data-table-bordered">
						@foreach ($items as $item)
							<div class="row">
								<div class="col-md-6">
									<p class="lead">{{ $item->present()->nameWithVersion }}</p>
									{{ $item->present()->disabledLabel }}
									{{ $item->present()->adminDisabledLabel }}
								</div>
								<div class="col-md-6">
									<div class="btn-toolbar pull-right">
										<div class="btn-group">
											<a href="{{ route('item.show', [$item->user->username, $item->slug]) }}" class="btn btn-default">View</a>
										</div>

										@if ($_currentUser->can('xtras.item.edit'))
											<div class="btn-group">
												<a href="{{ route('item.edit', [$item->user->username, $item->slug]) }}" class="btn btn-default">Edit</a>
											</div>
											<div class="btn-group">
												<a href="{{ route('item.messages.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Messages</a>
												<a href="{{ route('item.files.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Files</a>
												<a href="{{ route('item.images.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Images</a>
											</div>
										@endif

										@if ($_currentUser->can('xtras.item.delete'))
											<div class="btn-group">
												<a href="#" class="btn btn-danger js-remove-item" data-id="{{ $item->id }}">Remove</a>
											</div>
										@endif
									</div>
								</div>
							</div>
						@endforeach
						</div>
					@endforeach
				@else
					{{ alert('warning', "You don't have any rank sets.") }}
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