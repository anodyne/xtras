@extends('layouts.email')

@section('content')
	<h1>Comment Added</h1>

	<p>{{ $userName }} has commented on your {{ $type }} {{ $name }}.</p>

	<hr>

	{{ Markdown::parse($content) }}
@stop

@section('schema')
	<script type="application/ld+json">
		{
			"@context": "http://schema.org",
			"@type": "EmailMessage",
			"description": "View the Xtra",
			"action": {
				"@type": "ViewAction",
				"url": "{{ $url }}",
				"name": "View Xtra"
			},
			"publisher": {
				"@type": "Organization",
				"name": "AnodyneXtras",
				"url": "http://xtras.anodyne-productions.com"
			}
		}
	</script>
@stop