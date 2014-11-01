@extends('layouts.master')

@section('title')
	{{ $item->name }} - Manage Messages
@stop

@section('content')
	<h1>Messages <small>{{ $item->present()->name }}</small></h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('account.xtras') }}" class="btn btn-default">My Xtras</a>
		</div>
		<div class="btn-group">
			<a href="{{ route('item.messages.create', [$item->user->username, $item->slug]) }}" class="btn btn-primary">Create New Message</a>
		</div>
	</div>

	<p>Messages are blocks of text that will appear at the top of your public-facing Xtra page. You can use these messages to provided page visitors additional important information about your Xtra (e.g. "We are aware of the issue in the current version and are hoping to have a fix out in the next few days."). Messages can be <span class="text-info">informational</span>, <span class="text-warning">warnings</span>, or <span class="text-danger">critical</span>.</p>

	@if ($messages->count() > 0)
		<hr class="partial-split">

		@foreach ($messages as $message)
			<div class="row">
				<div class="col-md-10">
					{{ alert($message->type, $message->present()->content) }}
				</div>
				<div class="col-md-2">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="{{ route('item.messages.edit', [$message->id]) }}" class="btn btn-default">Edit</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-remove-message" data-message="{{ $message->id }}">Remove</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	@else
		{{ alert('warning', "No messages found.") }}
	@endif
@stop

@section('modals')
	{{ modal(['id' => 'removeMessage', 'header' => 'Remove Message']) }}
@stop

@section('scripts')
	<script>
		$('.js-remove-message').on('click', function(e)
		{
			e.preventDefault();

			var message = $(this).data('message');

			$('#removeMessage').modal({
				remote: "{{ URL::to('item/messages') }}/" + message + "/remove"
			}).modal('show');
		});
	</script>
@stop