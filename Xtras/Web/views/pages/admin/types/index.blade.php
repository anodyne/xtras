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
				<div class="col-md-9 col-lg-9">
					<p class="lead{{ ((bool) $type->display === false) ? ' text-muted' : '' }}">{{ $type->present()->name }}</p>
				</div>
				<div class="col-md-3 col-lg-3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-default js-edit-type" data-id="{{ $type->id }}">{{ $_icons['edit'] }}</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-delete-type" data-id="{{ $type->id }}">{{ $_icons['remove'] }}</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@else
		<p class="alert alert-warning">No item types found.</p>
	@endif
@stop

@section('modals')
	{{ modal(['id' => 'createType', 'header' => 'Create Item Type']) }}
	{{ modal(['id' => 'deleteType', 'header' => 'Delete Item Type']) }}
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

		$('.js-delete-type').on('click', function(e)
		{
			e.preventDefault();

			var type = $(this).data('id');

			$('#deleteType').modal({
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