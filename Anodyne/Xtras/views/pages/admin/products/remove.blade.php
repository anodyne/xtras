<p>Are you sure you want to delete the product <strong>{{ $product->present()->name }}</strong>?</p>

{{ Form::open(['route' => ['admin.products.destroy', $product->id], 'method' => 'delete']) }}
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				{{ Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-lg btn-danger']) }}
			</div>
		</div>
	</div>
{{ Form::close() }}