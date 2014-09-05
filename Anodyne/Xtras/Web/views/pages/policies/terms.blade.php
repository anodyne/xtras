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
		<dd>We've worked hard to build AnodyneXtras, but we're human. There are bound to be issues, snafus, and weird things along the way. We apologize in advance for those, but we're providing this service free of charge and on an "as is" and "as available" basis. If you let us know about an issue you're having, we'll gladly look to address it as quickly as possible.</dd>

		<dt>No Breaking the Law</dt>
		<dd>Simply put, if it's illegal or unauthorized where you live, don't do it here either.</dd>

		<dt>No Advertising</dt>
		<dd>We all want to add a few more people to our games, but this is not the time or place to do so. Advertising your game, site, service, or any other non-affiliated service will result in account suspension or termination.</dd>

		<dt>It Belongs to YOU</dt>
		<dd>Your account is your account. That means you (and you alone) are responsible for maintaining the security of your account.</dd>
		<dd>You are responsible for all activity and content posted from your account.</dd>
		<dd>Even though we're hosting it, your content will always be your content. By uploading it to AnodyneXtras, you're agreeing to allow others to view and use your content. If you don't want other people using it, don't upload it.</dd>

		<dt>Don't Be a Jerk</dt>
		<dd>Don't put worms, viruses, trojans, or any code of a destructive or malicious nature into your Xtras.</dd>
		<dd>Don't use AnodyneXtras to transmit any unsolicited ("spam") messages to users.</dd>
		<dd>Don't steal other people's hard work, whether it's content from within AnodyneXtras or outside of it.</dd>

		<dt>Don't Hog All the Space</dt>
		<dd>Anodyne Productions pays for the space used for storing all of the content available on AnodyneXtras. If you're using too much space, we reserve the right to disable your account or suspend your ability to upload until you can reduce how much space you're using.</dd>

		<dt>Removal of Content</dt>
		<dd>We don't pre-screen any Xtras before they're available.</dd>
		<dd>We may (though have no obligation to) remove Xtras and accounts containing content that we determine in our sole discretion to be unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or otherwise objectionable or that violates someone else's intellectual property.</dd>

		<dt>Be Nice</dt>
		<dd>Verbal, physical, written or other abuse (including threats of abuse or retribution) of any Anodyne Production customer or employee will result in immediate account termination.</dd>
	</dl>
@stop