<p>Are you sure you want to remove this message? This action is permanent and cannot be undone!</p>

{{ Form::open(['route' => ['item.messages.destroy', $message->id], 'method' => 'delete']) }}
	<div class="form-group">
		{{ Form::button('Remove', ['type' => 'submit', 'class' => 'btn btn-lg btn-danger']) }}
	</div>
{{ Form::close() }}