@extends('layouts.master')

@section('title')
	Products
@stop

@section('content')
	<h1>Products</h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('admin.products.create') }}" class="btn btn-primary">Create New Product</a>
		</div>
	</div>

	@if ($products->count() > 0)
		<div class="data-table data-table-striped data-table-bordered">
		@foreach ($products as $product)
			<div class="row">
				<div class="col-md-9 col-lg-9">
					<p class="lead">{{ $product->present()->name }}</p>
				</div>
				<div class="col-md-3 col-lg-3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="{{ route('admin.products.edit', [$product->id]) }}" class="btn btn-default">{{ $_icons['edit'] }}</a>
						</div>
						<div class="btn-group">
							<a href="{{ route('admin.products.destroy', [$product->id]) }}" class="btn btn-danger">{{ $_icons['remove'] }}</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@else
		<p class="alert alert-warning">No products found.</p>
	@endif
@stop