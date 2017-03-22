@extends('layouts.email')

@section('content')
	<h1>Issue Report</h1>

	<p>An issue has been reported with one of your Xtras. The information about the Xtra is below as well as comments from the reporting user. If you have questions about the issue report, please contact the user directly.</p>

	<hr>
		
	<ul>
		<li><strong>Item:</strong> {{ $name }}</li>
		<li><strong>Item Type:</strong> {{ $type }}</li>
		<li><strong>Reported By:</strong> {{ $userName }} ({{ $userEmail }})</li>
	</ul>

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
				"url": "https://xtras.anodyne-productions.com"
			}
		}
	</script>
@stop