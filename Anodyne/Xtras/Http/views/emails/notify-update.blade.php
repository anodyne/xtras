@extends('layouts.email')

@section('content')
	<h1>Xtra Updated</h1>

	<p>The {{ $type }} {{ $name }} has been recently been updated.</p>

	<hr>
		
	<ul>
		<li><strong>Item:</strong> {{ $name }}</li>
		<li><strong>Item Type:</strong> {{ $type }}</li>
		<li><strong>Version:</strong> {{ $version }}</li>
	</ul>

	{{ $history }}
@stop