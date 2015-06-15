@extends('layouts.master')

@section('title')
	Add Comment to Xtra
@stop

@section('content')
	<h1>Add Comment to Xtra <small>{{ $item->present()->name }}</small></h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('item.show', [$item->user->username, $item->slug]) }}" class="btn btn-default">Back</a>
		</div>
	</div>

	{{ Form::open(['route' => ['item.comment.store', $item->id]]) }}
		<div class="row">
			<div class="col-md-10">
				<div class="form-group">
					{{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5]) }}
					<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				{{ Form::button('Add Comment', ['type' => 'submit', 'class' => 'btn btn-primary btn-lg']) }}
			</div>
		</div>
	{{ Form::close() }}

	@if ($comments->count() > 0)
		<hr class="partial-split">

		<h2>Comments on This Xtra</h2>

		@foreach ($comments as $comment)
			@if ($comment->user->id == $item->user->id)
				<blockquote class="author">
			@else
				<blockquote>
			@endif
				{{ $comment->present()->content }}
				{{ $comment->present()->author }}
			</blockquote>
		@endforeach
	@endif
@stop