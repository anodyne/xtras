@extends('layouts.master')

@section('title')
	{{ $user->name }}
@stop

@section('content')
	<h1>{{ $user->name }}</h1>

	@if ( ! empty($user->url))
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ $user->url }}" target="_blank" class="btn btn-small btn-default">Visit website</a>
			</div>
		</div>
	@endif

	<p>{{ $user->bio }}</p>

	<h2>Xtras</h2>
@stop