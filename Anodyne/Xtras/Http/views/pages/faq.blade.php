@extends('layouts.master')

@section('title')
	FAQs
@stop

@section('content')
	<h1>Frequently Asked Questions</h1>

	<ul class="nav nav-pills">
		<li class="active"><a href="#general" data-toggle="pill"><span class="tab-icon tab-icon-up3">{{ $_icons['question'] }}</span>General Questions</a></li>
		<li><a href="#creating" data-toggle="pill"><span class="tab-icon tab-icon-up3">{{ $_icons['new'] }}</span>Creating Xtras</a></li>
		<li><a href="#updating" data-toggle="pill"><span class="tab-icon tab-icon-up3">{{ $_icons['edit'] }}</span>Updating Xtras</a></li>
		<li><a href="#removing" data-toggle="pill"><span class="tab-icon tab-icon-up3">{{ $_icons['remove'] }}</span>Removing Xtras</a></li>
	</ul>

	<div class="tab-content">
		<div id="general" class="tab-pane active">
			<h3>Why do I need to register to download Xtras?</h3>
			<p>In order to provide notification services when an Xtra is updated, you need to have an account. This also allows you to have a complete history of your download history.</p>

			<hr class="partial-split">

			<h3>I found an issue with an Xtra, how do I report it to the developer?</h3>
			<p>On the Xtra's page, there's a button to <strong>Report an Issue</strong>. That message will go straight to the Xtra developer for them to look into. Anodyne Productions isn't responsible for other authors' content, so issues should not be reported to Anodyne unless it pertains to potential abuse.</p>

			<hr class="partial-split">

			<h3>I think an Xtra is doing something malicious or wrong that Anodyne Productions should be aware of, how do I report that?</h3>
			<p>On the Xtra's page, there's a button to <strong>Report Abuse</strong>. That message will come straight to us and we'll look into the abuse immediately. Abuse reports are anonymous to the author of the Xtra and your information will never be shared with the author.</p>
		</div>

		<div id="creating" class="tab-pane">
			<h3>Can I have an Xtra that targets multiple versions of Nova?</h3>
			<p>No. We considered allowing this, but in the end, we felt it would've created more confusion if a user went to the same place to get different versions of an Xtra. It would be easy to accidentally get the wrong version. By forcing Xtras to have separate versions for each version of Nova, everything from preview images, version history, installation instructions, and downloads are clearer.</p>

			<hr class="partial-split">

			<h3>Can I have more than 3 preview images for my Xtra?</h3>
			<p>No. We have decided on allowing 3 preview images at this point.</p>

			<hr class="partial-split">

			<h3>Why can't I create a rank set Xtra?</h3>
			<p>Because of how complicated the rank system is in Nova 1 and 2, there are a limited number of users with access to create rank set Xtras. In the future, when Nova 3 is released, we'll open it up to more people. If you have a rank set you'd like to share, contact us and we'll consider providing you access to create a new rank set Xtra.</p>
		</div>

		<div id="updating" class="tab-pane">
			<h3>How do I update one of my Xtras with a new version?</h3>
			<p>If you want to add a new version to one of your Xtras, it's as simple as editing the Xtra. You'll update the basic information (including the version number) and then use the File Management page to add a new file for the version. If you need to update the preview images, you can do that as well from the Image Management page.</p>

			<hr class="partial-split">

			<h3>I tried to upload a new file for a new version of my Xtra, but it tells me there's already a file associated with that version.</h3>
			<p>Order matters! When updating your Xtra with a new version, you need to <em>first</em> update the Xtra with the new version <em>then</em> upload the zip archive.</p>
		</div>

		<div id="removing" class="tab-pane">
			<h3>How do I remove one of my Xtras?</h3>

			<hr class="partial-split">

			<h3>How do I disable one of my Xtras so it can't be seen by anyone?</h3>
		</div>
	</div>
@stop