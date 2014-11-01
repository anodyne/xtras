@extends('layouts.master')

@section('title')
	{{ $item->name }} - Manage Files
@stop

@section('content')
	<h1>Files <small>{{ $item->present()->name }}</small></h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('account.xtras') }}" class="btn btn-default">My Xtras</a>
		</div>
		<div class="btn-group">
			<a href="{{ route('item.files.create', [$item->user->username, $item->slug]) }}" class="btn btn-primary">Upload New File</a>
		</div>
	</div>

	@if ($files->count() > 0)
		<div class="data-table data-table-bordered data-table-striped">
		@foreach ($files as $file)
			<div class="row">
				<div class="col-md-8">
					<p class="lead">{{ $item->present()->name }} {{ $file->present()->version }}</p>
					<p class="text-sm text-muted">{{ $file->present()->filename }}</p>
				</div>
				<div class="col-md-2">
					<p class="text-muted">{{ $file->present()->added }}</p>
				</div>
				<div class="col-md-2">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-remove-file" data-file="{{ $file->id }}">Remove</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@else
		{{ alert('warning', "No files found.") }}
	@endif
@stop

@section('modals')
	{{ modal(['id' => 'removeFile', 'header' => 'Remove File']) }}
@stop

@section('scripts')
	<script>
		$('.js-remove-file').on('click', function(e)
		{
			e.preventDefault();

			var file = $(this).data('file');

			$('#removeFile').modal({
				remote: "{{ URL::to('item/files') }}/" + file + "/remove"
			}).modal('show');
		});
	</script>
@stop