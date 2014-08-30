<p>Are you sure you want to remove the file <strong>{{ $file->present()->filename }}</strong>? This action is permanent and cannot be undone!</p>

{{ Form::open(['route' => ['item.files.destroy', $file->id], 'method' => 'delete']) }}
	<div class="form-group">
		{{ Form::button('Remove', ['type' => 'submit', 'class' => 'btn btn-lg btn-danger']) }}
	</div>
{{ Form::close() }}