@extends('layouts.email')

@section('content')
	<h1>Comment Added</h1>

	<p>{{ $userName }} has commented on your {{ $type }} {{ $name }}.</p>

	<hr>

	{{ Markdown::parse($content) }}
@stop