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
	@endif

	@if ($skins->count() > 0)
		<h2>Skins</h2>

		<div class="data-table data-table-striped data-table-bordered">
		@foreach ($skins as $item)
			<div class="row">
				<div class="col-lg-8">
					<p class="lead">{{ $item->name }}</p>
				</div>
				<div class="col-lg-4">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-default">Upload File</a>
							<a href="#" class="btn btn-default">Edit Xtra</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger">Remove Xtra</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@endif

	@if ($ranks->count() > 0)
		<h2>Rank Sets</h2>

		<div class="data-table data-table-striped data-table-bordered">
		@foreach ($ranks as $item)
			<div class="row">
				<div class="col-lg-8">
					<p class="lead">{{ $item->name }}</p>
				</div>
				<div class="col-lg-4">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-default">Upload File</a>
							<a href="#" class="btn btn-default">Edit Xtra</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger">Remove Xtra</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@endif

	@if ($mods->count() > 0)
		<h2>MODs</h2>

		<div class="data-table data-table-striped data-table-bordered">
		@foreach ($mods as $item)
			<div class="row">
				<div class="col-lg-8">
					<p class="lead">{{ $item->name }}</p>
				</div>
				<div class="col-lg-4">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-default">Upload File</a>
							<a href="#" class="btn btn-default">Edit Xtra</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger">Remove Xtra</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@endif
@stop