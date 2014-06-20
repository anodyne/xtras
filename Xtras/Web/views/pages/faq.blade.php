@extends('layouts.master')

@section('title')
	FAQs
@stop

@section('content')
	<h1>Frequently Asked Questions</h1>

	<dl>
		<dt>Why do I need to register to view and download xtras?</dt>
		<dd>In order to provide notification services when an xtra is updated, you need to have an account.</dd>

		<dt>Why do I keep getting emails telling me an xtra has been updated? How do I stop the emails?</dt>
	</dl>

	<h2>Creating, Updating, &amp; Deleting Xtras</h2>

	<dl>
		<dt>Can I have an xtra that targets multiple versions of Nova?</dt>
		<dd>No. We considered allowing this, but in the end, we felt it would've created more confusion if a user went to the same place to get different versions of an xtra. It would be easy to accidentally get the wrong version. By forcing xtras to have separate versions for each version of Nova, everything from preview images, version history, installation instructions, and downloads are clearer.</dd>

		<dt>Can I have more than 3 preview images for my xtra?</dt>
		<dd>No. We have decided on allowing 3 preview images at this time.</dd>

		<dt>Why can't I create a rank set xtra?</dt>
		<dd>Because of how complicated the rank system is in Nova 1 and 2, there are a limited number of users with access to create rank set xtras. In the future, when Nova 3 is released, we'll open it up to more people. If you have a rank set you'd like to share, contact us and we'll consider providing you access to create a new rank set xtra.</dd>
	</dl>
@stop