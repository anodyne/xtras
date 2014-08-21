@extends('layouts.master')

@section('title')
	Items
@stop

@section('content')
	<h1>Items</h1>

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
							<a href="{{ route('admin.items.edit', [$item->id]) }}" class="btn btn-default">{{ $_icons['edit'] }}</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-delete-item" data-id="{{ $item->id }}">{{ $_icons['remove'] }}</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>

		{{ $items->links() }}
	@else
		<p class="alert alert-warning">No items found.</p>
	@endif
@stop

@section('modals')
	{{ modal(['id' => 'deleteItem', 'header' => 'Delete Item']) }}
@stop

@section('scripts')
	<script>
		$('.js-delete-item').on('click', function(e)
		{
			e.preventDefault();

			var item = $(this).data('id');

			$('#deleteItem').modal({
				remote: "{{ URL::to('admin/items') }}/" + item + "/remove"
			}).modal('show');
		});
	</script>
@stop