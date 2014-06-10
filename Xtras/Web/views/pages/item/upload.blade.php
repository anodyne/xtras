@extends('layouts.master')

@section('title')
	Upload Xtra
@stop

@section('content')
	<h1>Xtra Upload</h1>

	<div id="uploadZip">
		<h2>Zip File</h2>

		<ol>
			<li>
				Zip up your {{ Str::lower($item->present()->type) }} to your desktop. Only zip files will be accepted. This ensures users only have to download a single file.<br>
				@if ($browser->getPlatform() == Browser::PLATFORM_WINDOWS)
					<img src="{{ URL::asset('images/windows-zip.jpg') }}">
				@else
					<img src="{{ URL::asset('images/mac-zip.jpg') }}">
				@endif
			</li>
			<li>Drag-and-drop your zip file to the area below.</li>
			<li>When the <strong>Continue</strong> button appears, you can click it to continue the upload process and add preview images for your {{ Str::lower($item->present()->type) }}.</li>
		</ol>

		<p class="alert"><strong>Please note:</strong> While there are no file size limitations imposed, please try to keep your files to a reasonable size. If you're found to be uploading abnormally large files, limits could be imposed on your account or even suspended. If you have questions about acceptable file sizes and if your files meet that definition, contact us first.</p>

		<div id="dzZip" class="dropzone"></div>
	</div>

	<div id="uploadPreviews" class="hide">
		<h2>Preview Images</h2>

		<p>In order to cover all scenarios, you should upload a primary preview image that is at least 800 pixels wide and 300 pixels tall. This ensures that the preview image will be sharp and clear in all use cases, including high resolution displays.</p>

			<div class="row">
				<div class="col-lg-3">
					{{ Form::button('Upload and Continue', ['type' => 'submit', 'class' => 'btn btn-lg btn-block btn-primary']) }}
				</div>
				<div class="col-lg-9">
					<button class="btn btn-lg btn-link" disabled="disabled">Next Step: Notify Users of Update <span class="icn-size-16">{{ $_icons['next'] }}</span></button>
				</div>
			</div>
	</div>
@stop

@section('styles')
	{{ HTML::style('css/dropzone.css') }}
@stop

@section('scripts')
	{{ HTML::script('js/dropzone.min.js') }}
	<script>

		$(document).ready(function()
		{
			$('#dzZip').dropzone({
				url: "/file/post",
				clickable: true,
				acceptedFiles: ".zip"
			});
		});

	</script>
@stop