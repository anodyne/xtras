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
			<a href="{{ route('messages.create', [$item->user->username, $item->slug]) }}" class="btn btn-primary">Create New Message</a>
		</div>
	</div>

	<p>Messages are blocks of text that will appear at the top of your public-facing Xtra page. You can use these messages to provided page visitors additional important information about your Xtra (e.g. "We are aware of the issue in the current version and are hoping to have a fix out in the next few days."). Messages can be <span class="text-info">informational</span>, <span class="text-warning">warnings</span>, or <span class="text-danger">critical</span>.</p>

	@if ($messages->count() > 0)
		<div class="data-table data-table-bordered data-table-striped">
		@foreach ($messages as $message)
			<div class="row">
				<div class="col-md-1">
					<p>{{ $message->present()->typeAsLabel }}</p>
				</div>
				<div class="col-md-8">
					{{ $message->present()->content }}

					@if ( ! empty($message->expires))
						<p class="text-sm text-muted">{{ $message->present()->expiresRelative }}</p>
					@endif
				</div>
				<div class="col-md-3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="{{ route('messages.edit', [$message->id]) }}" class="btn btn-default">Edit</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger">Remove</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@else
		{{ alert('warning', "No messages found.") }}
	@endif
@stop