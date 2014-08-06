@extends('layouts.master')

@section('title')
	Privacy Policy
@stop

@section('content')
	<h1>Privacy Policy</h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ URL::route('policies') }}" class="btn btn-default">{{ $_icons['back'] }}</a>
		</div>
	</div>

	<h2>General Information</h2>

	<p>We do not share or sell your information to other organizations for commercial purposes. We hate when companies do that to us, so we're not going to do it to you. The only exceptions to this rule are:</p>

	<ul>
		<li>It is necessary to share information in order to investigate, prevent, or take action regarding illegal activities, suspected fraud, situations involving potential threats to the physical safety of any person, violations of <a href="{{ URL::route('policies', ['terms']) }}">Terms of Use</a>, or as otherwise required by law.</li>
		<li>We transfer information about you if Anodyne Productions is acquired by or merged with another company. In this event, Anodyne will notify you before information about you is transferred and becomes subject to a different privacy policy.</li>
	</ul>

	<h2>Information Gathering &amp; Usage</h2>

	<ul>
		<li>When you register for an Anodyne Productions account, we ask for information such as your name and email address.</li>
		<li>Anodyne Productions uses collected information for the following general purposes: products and services provision, identification and authentication, services improvement, contact, and research.</li>
	</ul>

	<h2>Cookies</h2>

	<ul>
		<li>A cookie is a small amount of data, which often includes an anonymous unique identifier, that is sent to your browser from a web site's computers and stored on your computer's hard drive.</li>
		<li>Cookies are required to use some Anodyne Productions services.</li>
		<li>We use cookies to record current session information, but do not use permanent cookies. You are required to re-login to your Anodyne Productions account after a certain period of time has elapsed to protect you against others accidentally accessing your account contents.</li>
	</ul>

	<h2>Data Storage</h2>

	<p>Anodyne Productions uses third party vendors and hosting partners to provide the necessary hardware, software, networking, storage, and related technology required to run Anodyne Productions and its affiliate sites. Although Anodyne Productions owns the code, databases, and all rights to Anodyne applications, you retain all rights to your data.</p>

	<h2>Disclosure</h2>

	<p>Anodyne Productions may disclose personally identifiable information under special circumstances, such as when your actions violate the <a href="{{ URL::route('policies', ['terms']) }}">Terms of Use</a>.</p>

	<h2>Changes</h2>

	<p>Anodyne Productions may periodically update this policy. We will notify you about significant changes in the way we treat personal information by sending a notice to the email address specified in your Anodyne account or by placing a prominent notice on our site.</p>

	<h2>Questions</h2>

	<p>Any questions about this Privacy Policy should be addressed to admin@anodyne-productions.com.</p>
@stop