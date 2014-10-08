@extends('layouts.master')

@section('title')
	Products
@stop

@section('content')
	<h1>Products</h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="#" class="btn btn-primary js-create-product">Create Product</a>
		</div>
	</div>

	@if ($products->count() > 0)
		<div class="data-table data-table-striped data-table-bordered">
		@foreach ($products as $product)
			<div class="row">
				<div class="col-md-9">
					<p class="lead{{ ((bool) $product->display === false) ? ' text-muted' : '' }}">{{ $product->present()->name }}</p>
				</div>
				<div class="col-md-3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-default js-edit-product" data-id="{{ $product->id }}">Edit</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-delete-product" data-id="{{ $product->id }}">Remove</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@else
		{{ alert('warning', "No products found.") }}
	@endif
@stop

@section('modals')
	{{ modal(['id' => 'createProduct', 'header' => 'Create Product']) }}
	{{ modal(['id' => 'removeProduct', 'header' => 'Remove Product']) }}
	{{ modal(['id' => 'editProduct', 'header' => 'Edit Product']) }}
@stop

@section('scripts')
	<script>
		$('.js-create-product').on('click', function(e)
		{
			e.preventDefault();

			$('#createProduct').modal({
				remote: "{{ route('admin.products.create') }}"
			}).modal('show');
		});

		$('.js-remove-product').on('click', function(e)
		{
			e.preventDefault();

			var product = $(this).data('id');

			$('#removeProduct').modal({
				remote: "{{ URL::to('admin/products') }}/" + product + "/remove"
			}).modal('show');
		});

		$('.js-edit-product').on('click', function(e)
		{
			e.preventDefault();

			var product = $(this).data('id');

			$('#editProduct').modal({
				remote: "{{ URL::to('admin/products') }}/" + product + "/edit"
			}).modal('show');
		});
	</script>
@stop