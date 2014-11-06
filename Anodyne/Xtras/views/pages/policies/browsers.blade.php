@extends('layouts.master')

@section('title')
	Supported Browsers
@stop

@section('content')
	<h1>Supported Browsers</h1>

	<div class="visible-xs visible-sm"></div>

	<div class="visible-md visible-lg">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ URL::route('policies') }}" class="btn btn-default">Back to Site Policies</a>
			</div>
		</div>
	</div>

	<p>Even though AnodyneXtras is designed to support the latest web browsers, we recommend using <a href="https://www.google.com/chrome/" target="_blank">Google Chrome</a>. It's fast and automatically keeps itself up-to-date. We also support the current versions of Safari and Firefox as well as well as IE 9+.</p>

	<p>While beta and developer builds of these browsers are likely to work, you may encounter unexpected bugs due to the unstable nature of these builds. If you encounter a bug on AnodyneXtras in one of these unreleased builds, please verify it also exists in the stable version of the same browser. If the bug appears to only exist in the unstable version, you should probably report it to the browser developer first.</p>

	<h2>IE Compatibility View</h2>

	<p>We only support IE running in "Standards Mode". If you see an error message saying your browser is outdated, it may be running in "Compatibility View". Turning off this compatibility mode will remove the outdated browser error.</p>

	<h3>IE 9</h3>

	<ol>
		<li>Visit <a href="{{ config('anodyne.links.xtras') }}">xtras.anodyne-productions.com</a></li>
		<li>
			Click the "Compatibility View" button in the address bar<br>
			<img src="{{ asset('images/ie9-compat-mode.jpeg') }}">
		</li>
		<li>Refresh the page</li>
	</ol>

	<h3>IE 10</h3>

	<p>IE10 should default to "Standards Mode". If you are getting the warning, the settings have likely been changed to force "Compatibility View" to be used.</p>

	<ol>
		<li>Open F12 developer tools by pressing the F12 key</li>
		<li>
			Set Browser Mode to "Internet Explorer 10"<br>
			<img src="{{ asset('images/IE10_browser_mode.png') }}">
		</li>
		<li>
			Set Document Mode to "Standards"<br>
			<img src="{{ asset('images/IE10_document_mode.png') }}">
		</li>
	</ol>
@stop