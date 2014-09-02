<p>Are you sure you want to remove this image? This action is permanent and cannot be undone!</p>

{{ Form::open(['route' => ['item.images.destroy', $item->id, $image], 'method' => 'delete']) }}
	<div class="form-group">
		{{ Form::button('Remove', ['type' => 'submit', 'class' => 'btn btn-lg btn-danger']) }}
	</div>
{{ Form::close() }}