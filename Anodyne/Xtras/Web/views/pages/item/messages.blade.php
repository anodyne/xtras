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
			<a href="{{ route('item.messages.create') }}" class="btn btn-primary">Create New Message</a>
		</div>
	</div>

	@if ($messages->count() > 0)
	@else
		{{ alert('warning', "No messages found.") }}
	@endif
@stop