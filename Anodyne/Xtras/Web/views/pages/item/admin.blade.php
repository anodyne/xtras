@extends('layouts.master')

@section('title')
	All Xtras
@stop

@section('content')
	<h1>All Xtras</h1>

	@if ($items->getTotal() > 0)
		{{ $items->links() }}

		<div class="data-table data-table-striped data-table-bordered">
		@foreach ($items as $item)
			<div class="row">
				<div class="col-md-9 col-lg-9">
					<p class="lead">{{ $item->present()->name }}</p>
					<p>
						{{ $item->present()->productAsLabel }}
						{{ $item->present()->typeAsLabel }}
					</p>
				</div>
				<div class="col-md-3 col-lg-3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="{{ route('item.edit', [$item->user->username, $item->slug, 'admin']) }}" class="btn btn-default">Edit</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-remove-item" data-id="{{ $item->id }}" data-admin="admin">Remove</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>

		{{ $items->links() }}
	@else
		{{ alert('warning', "No Xtras found.") }}
	@endif
@stop

@section('modals')
	{{ modal(['id' => 'removeItem', 'header' => 'Remove Xtra']) }}
@stop

@section('scripts')
	{{ partial('js/item-remove') }}
@stop