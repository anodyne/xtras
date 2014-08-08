@extends('layouts.email')

@section('content')
	<h1>Abuse Report</h1>

	<p>A user has reported an Xtra of abuse. The information about the Xtra is below as well as comments from the reporting user.</p>

	<hr>
		
	<ul>
		<li><strong>Item:</strong> {{ $name }}</li>
		<li><strong>Item Type:</strong> {{ $type }}</li>
		<li><strong>Reported By:</strong> {{ $userName }} ({{ $userEmail }})</li>
	</ul>

	{{ Markdown::parse($content) }}
@stop