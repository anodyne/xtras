@extends('layouts.master')

@section('title')
	{{ $item->name }} - Upload File
@stop

@section('content')
	<h1>Upload Zip File <small>{{ $item->present()->name }} {{ $item->present()->version }}</small></h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('item.files.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Back</a>
		</div>
	</div>

	@if ( ! $hasFile)
		<ol>
			<li>
				Zip up your {{ Str::lower($item->present()->type) }} to your desktop. Only zip files will be accepted. This ensures users only have to download a single file.<br>
				@if ($_browser->getPlatform() == Browser::PLATFORM_WINDOWS)
					<img src="{{ asset('images/windows-zip.jpg') }}">
				@else
					<img src="{{ asset('images/mac-zip.png') }}">
				@endif
			</li>
			<li>Drag-and-drop your zip file to the area below.</li>
		</ol>

		{{ alert('warning', "<strong>Please note:</strong> File uploads are capped at 64 MB per file. If you have questions about file sizes and any limitations, please contact us.") }}

		<p><div id="dzZip" class="dropzone"></div></p>

		<div class="hide" id="buttons">
			<div class="btn-toolbar">
				<div class="btn-group">
					<a href="{{ route('item.images.index', [$item->user->username, $item->slug]) }}" class="btn btn-lg btn-primary">Manage Xtra Images</a>
				</div>
				<div class="btn-group">
					<a href="{{ route('account.xtras') }}" class="btn btn-lg btn-default">My Xtras</a>
				</div>
			</div>
		</div>
	@else
		{{ alert('warning', "You already have a file associated with this version of your Xtra. In order to upload a new file, you need to ".link_to_route('item.edit', 'update the version info', [$item->user->username, $item->slug])." on your Xtra and then come back to upload your zip file.") }}
	@endif
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
				url: "{{ route('item.files.upload', [$item->id]) }}",
				clickable: true,
				acceptedFiles: ".zip",
				init: function()
				{
					this.on("success", function(file)
					{
						$('#buttons').removeClass('hide');
					});

					this.on("sending", function(file, xhr, formData)
					{
						formData.append("_token", "{{ csrf_token() }}");
					});

					this.on("error", function(file, errorMessage, xhr)
					{
						if (errorMessage == "File already exists")
							alert("There is already a file with that name. Make sure you have updated your Xtra version information before uploading a file.");
					});
				}
			});
		});
	</script>
@stop