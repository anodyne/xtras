@extends('layouts.master')

@section('title')
	Terms of Use
@stop

@section('content')
	<h1>Terms of Use</h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ URL::route('policies') }}" class="btn btn-default">Back to Site Policies</a>
		</div>
	</div>

	<dl>
		<dt>"As is/available"</dt>
		<dd>We've worked hard to build this Service, but we're human. There are bound to be bugs, snafus, and weird issues along the way. We apologize in advance for those, but we're providing this Service free of charge and on an "as is" and "as available" basis. If you let us know about an issue you're having, we'll gladly look to address it as quickly as possible.</dd>

		<dt>No Breaking the Law</dt>
		<dd>Simply put, if it's illegal or unauthorized where you live, don't do it here either.</dd>

		<dt>No Advertising</dt>
		<dd>We all want to add a few more people to our games, but this is not the time or place to do so. Advertising your game, site, service, or any other non-affiliated service will result in account suspension or termination.</dd>

		<dt>It Belongs to YOU</dt>
		<dd>Your account is your account. That means you (and you alone) are responsible for maintaining the security of your account.</dd>
		<dd>You are responsible for all activity and Content posted from your account.</dd>
		<dd>Even though we're hosting it, your Content will always be your Content. By uploading it to the Service, you're agreeing to allow others to view and use the Content. If you don't want other people using it, don't upload it.</dd>

		<dt>Don't Be a Jerk</dt>
		<dd>Don't put worms, viruses, trojans, or any code of a destructive or malicious nature into your Content.</dd>
		<dd>Don't use the Service to transmit any unsolicited ("spam") messages to users of the Service.</dd>
		<dd>Don't steal other people's hard work, whether it's Content from within the Service or outside of it.</dd>

		<dt>Don't Hog All the Space</dt>
		<dd>Anodyne pays for the space used for storing all of the Content available through the Service. If you're using too much space, we reserve the right to disable your account or suspend your ability to upload to the Service until you can reduce how much space you're using.</dd>

		<dt>Removal of Content</dt>
		<dd>We don't pre-screen any Content before it's available on the Service.</dd>
		<dd>We may, though have no obligation to, remove Content and Accounts containing Content that we determine in our sole discretion to be unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or otherwise objectionable or that violates someone else's intellectual property.</dd>

		<dt>Be Nice</dt>
		<dd>Verbal, physical, written or other abuse (including threats of abuse or retribution) of any Anodyne customer, employee, member, or officer will result in immediate account termination.</dd>
	</dl>
@stop