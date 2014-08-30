<p>Are you sure you want to delete the Xtra <strong>{{ $item->present()->name }}</strong>? This action is permanent and cannot be undone!</p>

{{ Form::open(['route' => ['item.destroy', $item->id], 'method' => 'delete']) }}
	<div class="form-group">
		{{ Form::button('Remove', ['type' => 'submit', 'class' => 'btn btn-lg btn-danger']) }}
	</div>
{{ Form::close() }}