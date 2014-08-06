@extends('layouts.master')

@section('title')
	My Xtras
@stop

@section('content')
	<h1>My Xtras</h1>

	@if ($_currentUser->can('xtras.item.create'))
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ URL::route('item.create') }}" class="btn btn-primary">Create New Xtra</a>
			</div>
		</div>
	@endif

	@if (count($skins) == 0 and count($ranks) == 0 and count($mods) == 0)
		<p class="alert alert-warning">It looks like you don't have any Xtras. Go ahead and change that, create your first!</p>
	@else
		<ul class="nav nav-tabs">
			<li class="active"><a href="#skins" data-toggle="tab">Skins</a></li>
			<li><a href="#mods" data-toggle="tab">MODs</a></li>
			<li><a href="#ranks" data-toggle="tab">Rank Sets</a></li>
		</ul>

		<div class="tab-content">
			<div id="skins" class="active tab-pane">
				@if (count($skins) > 0)
					@foreach ($skins as $product => $items)
						<h2>{{ $product }}</h2>
						<div class="data-table data-table-striped data-table-bordered">
						@foreach ($items as $item)
							<div class="row {{ $item->product->present()->nameAsSlug }}">
								<div class="col-lg-8">
									<p class="lead">{{ $item->present()->name }}</p>
								</div>
								<div class="col-lg-4">
									<div class="btn-toolbar pull-right">
										<div class="btn-group">
											<a href="#" class="btn btn-default">{{ $_icons['warning'] }}</a>
											<a href="{{ URL::route('item.edit', [$item->user->slug, $item->slug]) }}" class="btn btn-default">{{ $_icons['edit'] }}</a>
										</div>
										<div class="btn-group">
											<a href="#" class="btn btn-danger">{{ $_icons['remove'] }}</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach
						</div>
					@endforeach
				@else
					<p class="alert alert-warning">You don't have any skins.</p>
				@endif
			</div>

			<div id="mods" class="tab-pane">
				@if (count($mods) > 0)
					@foreach ($mods as $product => $items)
						<h2>{{ $product }}</h2>
						<div class="data-table data-table-striped data-table-bordered">
						@foreach ($items as $item)
							<div class="row">
								<div class="col-lg-8">
									<p class="lead">{{ $item->present()->name }}</p>
								</div>
								<div class="col-lg-4">
									<div class="btn-toolbar pull-right">
										<div class="btn-group">
											<a href="#" class="btn btn-default">{{ $_icons['warning'] }}</a>
											<a href="{{ URL::route('item.edit', [$item->user->slug, $item->slug]) }}" class="btn btn-default">{{ $_icons['edit'] }}</a>
										</div>
										<div class="btn-group">
											<a href="#" class="btn btn-danger">{{ $_icons['remove'] }}</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach
						</div>
					@endforeach
				@else
					<p class="alert alert-warning">You don't have any MODs.</p>
				@endif
			</div>

			<div id="ranks" class="tab-pane">
				@if (count($ranks) > 0)
					@foreach ($ranks as $product => $items)
						<h2>{{ $product }}</h2>
						<div class="data-table data-table-striped data-table-bordered">
						@foreach ($items as $item)
							<div class="row">
								<div class="col-lg-8">
									<p class="lead">{{ $item->present()->name }}</p>
								</div>
								<div class="col-lg-4">
									<div class="btn-toolbar pull-right">
										<div class="btn-group">
											<a href="#" class="btn btn-default">{{ $_icons['warning'] }}</a>
											<a href="{{ URL::route('item.edit', [$item->user->slug, $item->slug]) }}" class="btn btn-default">{{ $_icons['edit'] }}</a>
										</div>
										<div class="btn-group">
											<a href="#" class="btn btn-danger">{{ $_icons['remove'] }}</a>
										</div>
									</div>
								</div>
							</div>
						@endforeach
						</div>
					@endforeach
				@else
					<p class="alert alert-warning">You don't have any rank sets.</p>
				@endif
			</div>
		</div>
	@endif
@stop