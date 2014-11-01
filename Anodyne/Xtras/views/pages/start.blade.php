@extends('layouts.master')

@section('title')
	Getting Started
@stop

@section('content')
	<h1>Getting Started with AnodyneXtras</h1>

	<p>We've worked hard to make the new AnodyneXtras as simple and straightforward as possible. Here are few tips to help you get started.</p>

	<hr class="partial-split">

	<div class="row">
		<div class="col-md-7">
			<h2>My Xtras</h2>
			<p>After you've created your Xtras, you'll be able to access any of them from My Xtras. From here, you can create new Xtras, edit your existing Xtras (including any messages, files, and images), and remove Xtras if you need to. In addition, you'll be able to see a full breakdown of your Xtras and how much space they're taking up.</p>
		</div>
		<div class="col-md-5 text-right">{{ HTML::image('images/start/my-xtras.jpg', false, ['class' => 'preview-image preview-image-subtle']) }}</div>
	</div>

	<hr class="partial-split">

	<div class="row">
		<div class="col-md-5">{{ HTML::image('images/start/create.jpg', false, ['class' => 'preview-image preview-image-subtle']) }}</div>
		<div class="col-md-7 text-right">
			<h2>Creating an Xtra</h2>
			<p>When it comes time to share your Nova content with the wider community, you can create a new Xtra in 3 simple steps.</p>

			<ol>
				<li>Fill in basic information about your Xtra, like what kind of Xtra it is (a skin, rank set, or MOD), the Nova version it's for (Xtras can only be created for a single version of Nova), a name, description, some installation instructions, support link or email address, and the version history.</li>

				<li>Drag-n-drop your zip file onto the drop area and it'll automatically be named appropriately, uploaded to the server, and associated with the Xtra you just created.</li>

				<li>You can choose to upload up to three preview images with the same, simple drag-n-drop interface. If you choose not to upload any preview images, we'll randomly assign an image when displaying Xtras so that yours doesn't stand out from the rest.</li>
			</ol>
		</div>
	</div>

	<hr class="partial-split">

	<div class="row">
		<div class="col-md-7">
			<h2>Updating an Xtra</h2>
			<p>It's inevitable that you'll need to update your Xtra. Whether it's an issue you've fixed or an enhancement you're making, updates are an important part of managing your content.</p>

			<p>If you just need to make a quick update, the Quick Update screen will let you update the version, version history, and upload a file. If you need to edit more than just those fields, you can edit the Xtra, make your changes, and then upload a new file from File Management.</p>

			<p>Once your update is finished, anyone who's asked to be notified of updates will receive an email about the update.</p>
		</div>
		<div class="col-md-5 text-right">{{ HTML::image('images/start/update.jpg', false, ['class' => 'preview-image preview-image-subtle']) }}</div>
	</div>

	<hr class="partial-split">

	<div class="row">
		<div class="col-md-5">{{ HTML::image('images/start/messages.jpg', false, ['class' => 'preview-image preview-image-subtle']) }}</div>
		<div class="col-md-7 text-right">
			<h2>Messages</h2>
			<p>Messages allow you to show visitors to your item's page informational messages about whatever you want. You have 3 options for message types: information, warning, and critical.</p>

			<p>You can also set an expiration date on your message to have it automatically vanish at the end of the day you specify.</p>
		</div>
	</div>

	<hr class="partial-split">

	<div class="row">
		<div class="col-md-7">
			<h2>Files</h2>
			<p>Each Xtra can have only one file associated with each version. (If you already have a file associated with a version, you won't be able to upload a new one.) From the File management screen, you can remove files from your Xtra (to either clean up space or allow you to upload a new zip file for that version) and upload files to the server.</p>
		</div>
		<div class="col-md-5 text-right">{{ HTML::image('images/start/files.jpg', false, ['class' => 'preview-image preview-image-subtle']) }}</div>
	</div>

	<hr class="partial-split">

	<div class="row">
		<div class="col-md-5">{{ HTML::image('images/start/images.jpg', false, ['class' => 'preview-image preview-image-subtle']) }}</div>
		<div class="col-md-7 text-right">
			<h2>Images</h2>
			<p>Every Xtra can have up to three images associated with it. If you don't upload a preview image, AnodyneXtras will assign a random image to your Xtra to help it fit in with the other Xtras. You can add, change, remove, and set a new primary image from the Image Management screen.</p>

			<p>The primary image will always be indicated by a pink border around the content so you can easily see which is the primary image.</p>
		</div>
	</div>

	<hr class="partial-split">

	<div class="row">
		<div class="col-md-7">
			<h2>Ratings &amp; Notifications</h2>
			<p>Feedback is an important part of making your content available. If you do a great job, people should be able to give you a "kudos" for your hard work. On the flip side, if everything isn't up to snuff, it's important to know that so you can make improvements to your work.</p>

			<p>AnodyneXtras lets users rate your Xtras on a scale of 1 to 5. Those ratings will be compiled and averaged to give your Xtra a rating.</p>

			<p>In addition, users can choose to be notified when an update is made to your Xtra. This is a great way for users to get the latest version of your work as soon as it's available!</p>

			{{ alert('warning', "You won't see either of these sections if you visit your own Xtras as it wouldn't make much sense for you to be rating or marking yourself to be notified of updates to your own Xtras.") }}
		</div>
		<div class="col-md-5 text-right">{{ HTML::image('images/start/ratings-notifications.jpg', false, ['class' => 'preview-image preview-image-subtle']) }}</div>
	</div>
@stop