@extends('layouts.master')

@section('title')
	My Xtras
@stop

@section('content')
	<h1>My Xtras</h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ URL::route('xtra.create') }}" class="btn btn-primary">Add New Xtra</a>
		</div>
	</div>

	@if ($skins->count() == 0 and $ranks->count() == 0 and $mods->count() == 0)
		{{ partial('alert', ['type' => 'warning', 'content' => "It looks like you don't have any Xtras. Go ahead and change that and create your first!"]) }}
	@else
		<ul class="nav nav-tabs">
			<li class="active"><a href="#skins" data-toggle="tab">Skins</a></li>
			<li><a href="#ranks" data-toggle="tab">Rank Sets</a></li>
			<li><a href="#mods" data-toggle="tab">MODs</a></li>
		</ul>

		<div class="tab-content">
			<div id="skins" class="active tab-pane">
				<div class="btn-toolbar">
					<div class="btn-group">
						<a href="#" class="btn btn-sm btn-default">Show All</a>
					</div>
					<div class="btn-group">
						<a href="#" class="btn btn-sm btn-default">Nova 1</a>
						<a href="#" class="btn btn-sm btn-default">Nova 2</a>
						<a href="#" class="btn btn-sm btn-default">Nova 3</a>
					</div>
				</div>

				<div class="data-table data-table-striped data-table-bordered">
				@foreach ($skins as $item)
					<div class="row">
						<div class="col-lg-8">
							<p class="lead">{{ $item->present()->name }}</p>
						</div>
						<div class="col-lg-4">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="#" class="btn btn-default">{{ $_icons['upload'] }}</a>
									<a href="#" class="btn btn-default">{{ $_icons['edit'] }}</a>
								</div>
								<div class="btn-group">
									<a href="#" class="btn btn-danger">{{ $_icons['remove'] }}</a>
								</div>
							</div>
						</div>
					</div>
				@endforeach
				</div>
			</div>

			<div id="ranks" class="tab-pane">
				<div class="btn-toolbar">
					<div class="btn-group">
						<a href="#" class="btn btn-sm btn-default">Show All</a>
					</div>
					<div class="btn-group">
						<a href="#" class="btn btn-sm btn-default">Nova 1</a>
						<a href="#" class="btn btn-sm btn-default">Nova 2</a>
						<a href="#" class="btn btn-sm btn-default">Nova 3</a>
					</div>
				</div>

				<div class="data-table data-table-striped data-table-bordered">
				@foreach ($ranks as $item)
					<div class="row">
						<div class="col-lg-8">
							<p class="lead">{{ $item->present()->name }}</p>
						</div>
						<div class="col-lg-4">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="#" class="btn btn-default">{{ $_icons['upload'] }}</a>
									<a href="#" class="btn btn-default">{{ $_icons['edit'] }}</a>
								</div>
								<div class="btn-group">
									<a href="#" class="btn btn-danger">{{ $_icons['remove'] }}</a>
								</div>
							</div>
						</div>
					</div>
				@endforeach
				</div>
			</div>

			<div id="mods" class="tab-pane">
				<div class="btn-toolbar">
					<div class="btn-group">
						<a href="#" class="btn btn-sm btn-default">Show All</a>
					</div>
					<div class="btn-group">
						<a href="#" class="btn btn-sm btn-default">Nova 1</a>
						<a href="#" class="btn btn-sm btn-default">Nova 2</a>
						<a href="#" class="btn btn-sm btn-default">Nova 3</a>
					</div>
				</div>

				<div class="data-table data-table-striped data-table-bordered">
				@foreach ($mods as $item)
					<div class="row">
						<div class="col-lg-8">
							<p class="lead">{{ $item->present()->name }}</p>
						</div>
						<div class="col-lg-4">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="#" class="btn btn-default">{{ $_icons['upload'] }}</a>
									<a href="#" class="btn btn-default">{{ $_icons['edit'] }}</a>
								</div>
								<div class="btn-group">
									<a href="#" class="btn btn-danger">{{ $_icons['remove'] }}</a>
								</div>
							</div>
						</div>
					</div>
				@endforeach
				</div>
			</div>
		</div>
	@endif
@stop