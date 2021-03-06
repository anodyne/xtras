@extends('layouts.master')

@section('title')
	Item Types
@stop

@section('content')
	<h1>Item Types</h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="#" class="btn btn-primary js-create-type">Create Item Type</a>
		</div>
	</div>

	@if ($types->count() > 0)
		<div class="data-table data-table-striped data-table-bordered">
		@foreach ($types as $type)
			<div class="row">
				<div class="col-md-9">
					<p class="lead{{ ((bool) $type->display === false) ? ' text-muted' : '' }}">{{ $type->present()->name }}</p>
				</div>
				<div class="col-md-3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-default js-edit-type" data-id="{{ $type->id }}">Edit</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-delete-type" data-id="{{ $type->id }}">Remove</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@else
		{{ alert('warning', "No item types found.") }}
	@endif
@stop

@section('modals')
	{{ modal(['id' => 'createType', 'header' => 'Create Item Type']) }}
	{{ modal(['id' => 'removeType', 'header' => 'Remove Item Type']) }}
	{{ modal(['id' => 'editType', 'header' => 'Edit Item Type']) }}
@stop

@section('scripts')
	<script>
		$('.js-create-type').on('click', function(e)
		{
			e.preventDefault();

			$('#createType').modal({
				remote: "{{ route('admin.types.create') }}"
			}).modal('show');
		});

		$('.js-remove-type').on('click', function(e)
		{
			e.preventDefault();

			var type = $(this).data('id');

			$('#removeType').modal({
				remote: "{{ URL::to('admin/types') }}/" + type + "/remove"
			}).modal('show');
		});

		$('.js-edit-type').on('click', function(e)
		{
			e.preventDefault();

			var type = $(this).data('id');

			$('#editType').modal({
				remote: "{{ URL::to('admin/types') }}/" + type + "/edit"
			}).modal('show');
		});
	</script>
@stop