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

@section('schema')
	<script type="application/ld+json">
		{
			"@context": "http://schema.org",
			"@type": "EmailMessage",
			"description": "View the updated Xtra",
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