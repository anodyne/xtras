<p>Are you sure you want to delete the item type <strong>{{ $type->present()->name }}</strong>?</p>

{{ Form::open(['route' => ['admin.types.destroy', $type->id], 'method' => 'delete']) }}
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				{{ Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-lg btn-danger']) }}
			</div>
		</div>
	</div>
{{ Form::close() }}