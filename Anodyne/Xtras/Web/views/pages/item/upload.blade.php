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
		<p class="alert alert-success">The zip archive has been successfully uploaded!</p>

		<h2>Preview Images</h2>

		<p>In order to cover all scenarios, you should upload a primary preview image that is at least 700 pixels wide and 300 pixels tall. This ensures that the preview image will be sharp and clear in all use cases, including on high resolution displays.</p>

		<div class="row">
			<div class="col-md-4">
				<div id="dzPreviews1" class="dropzone"></div>
			</div>
			<div class="col-md-4">
				<div id="dzPreviews2" class="dropzone"></div>
			</div>
			<div class="col-md-4">
				<div id="dzPreviews3" class="dropzone"></div>
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
		Dropzone.autoDiscover = false;

		$(function()
		{
			var zipUpload = $('#dzZip').dropzone({
				url: "{{ URL::route('item.upload.doZip', [$item->id]) }}",
				clickable: true,
				acceptedFiles: ".zip",
				init: function()
				{
					this.on("success", function(file)
					{
						$('#uploadZip').addClass('hide');
						$('#uploadPreviews').removeClass('hide');
					});

					this.on("sending", function(file, xhr, formData)
					{
						formData.append("_token", "{{ csrf_token() }}");
					});
				}
			});

			var previewsUpload1 = $('#dzPreviews1').dropzone({
				url: "{{ URL::route('item.upload.doImages', [$item->id, 'image1']) }}",
				clickable: true,
				acceptedFiles: ".jpg, .jpeg, .png, .gif, .bmp",
				paramName: "image1",
				init: function()
				{
					this.on("sending", function(file, xhr, formData)
					{
						formData.append("_token", "{{ csrf_token() }}");
					});
				}
			});

			var previewsUpload2 = $('#dzPreviews2').dropzone({
				url: "{{ URL::route('item.upload.doImages', [$item->id, 'image2']) }}",
				clickable: true,
				acceptedFiles: ".jpg, .jpeg, .png, .gif, .bmp",
				paramName: "image2",
				init: function()
				{
					this.on("sending", function(file, xhr, formData)
					{
						formData.append("_token", "{{ csrf_token() }}");
					});
				}
			});

			var previewsUpload3 = $('#dzPreviews3').dropzone({
				url: "{{ URL::route('item.upload.doImages', [$item->id, 'image3']) }}",
				clickable: true,
				acceptedFiles: ".jpg, .jpeg, .png, .gif, .bmp",
				paramName: "image3",
				init: function()
				{
					this.on("sending", function(file, xhr, formData)
					{
						formData.append("_token", "{{ csrf_token() }}");
					});
				}
			});
		});
	</script>
@stop