@extends('layouts.master')

@section('title')
	{{ $item->present()->name }} - Manage Images
@stop

@section('content')
	<h1>Images <small>{{ $item->present()->name }}</small></h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('account.xtras') }}" class="btn btn-default">My Xtras</a>
		</div>
	</div>

	<p>In order to cover all scenarios, we recommend uploading a primary preview image (indicated by the pink border below) that is at least <strong>700 pixels wide</strong> and <strong>300 pixels tall</strong>. This ensures that the preview image will be sharp and clear in all use cases, including on high resolution displays.</p>

	<div class="row">
		<div class="col-md-4">
			<div class="preview-image preview-image-primary">
				@if ( ! empty($metadata->image1))
					<div class="text-center">
						<p><img src="{{ $metadata->present()->thumbnail1 }}"></p>
						<p><a href="#" class="btn btn-sm btn-danger js-remove-image" data-item="{{ $item->id }}" data-image="1">Remove Image</a></p>
					</div>
				@endif

				<div id="dzImage1" class="dropzone"></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="preview-image">
				@if ( ! empty($metadata->image2))
					<div class="text-center">
						<p><img src="{{ $metadata->present()->thumbnail2 }}"></p>
						<p>
							<a href="#" class="btn btn-sm btn-danger js-remove-image" data-item="{{ $item->id }}" data-image="2">Remove Image</a>
							&nbsp;
							<a href="#" class="btn btn-sm btn-default js-primary-image" data-item="{{ $item->id }}" data-image="2">Make Primary</a>
						</p>
					</div>
				@endif

				<div id="dzImage2" class="dropzone"></div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="preview-image">
				@if ( ! empty($metadata->image3))
					<div class="text-center">
						<p><img src="{{ $metadata->present()->thumbnail3 }}"></p>
						<p>
							<a href="#" class="btn btn-sm btn-danger js-remove-image" data-item="{{ $item->id }}" data-image="3">Remove Image</a>
							&nbsp;
							<a href="#" class="btn btn-sm btn-default js-primary-image" data-item="{{ $item->id }}" data-image="3">Make Primary</a>
						</p>
					</div>
				@endif

				<div id="dzImage3" class="dropzone"></div>
			</div>
		</div>
	</div>
@stop

@section('modals')
	{{ modal(['id' => 'removeImage', 'header' => 'Remove Image']) }}
@stop

@section('styles')
	{{ HTML::style('css/dropzone.css') }}
@stop

@section('scripts')
	{{ HTML::script('js/dropzone.min.js') }}
	<script>
		Dropzone.autoDiscover = false;

		$('.js-remove-image').on('click', function(e)
		{
			e.preventDefault();

			var item = $(this).data('item');
			var image = $(this).data('image');

			$('#removeImage').modal({
				remote: "{{ URL::to('item/images') }}/" + item + "/" + image + "/remove"
			}).modal('show');
		});

		$('.js-primary-image').on('click', function(e)
		{
			e.preventDefault();

			var $this = $(this);
			var item = $(this).data('item');
			var image = $(this).data('image');

			$.ajax({
				type: "POST",
				url: "{{ route('item.images.primary') }}",
				data: {
					item: item,
					image: image,
					"_token": "{{ csrf_token() }}"
				},
				dataType: "json",
				success: function(data)
				{
					window.location.reload();
				}
			});
		});

		$(function()
		{
			var previewsUpload1 = $('#dzImage1').dropzone({
				url: "{{ route('item.images.upload', [$item->id, 'image1']) }}",
				clickable: true,
				acceptedFiles: ".jpg, .jpeg, .png, .gif, .bmp",
				paramName: "image1",
				init: function()
				{
					this.on("sending", function(file, xhr, formData)
					{
						formData.append("_token", "{{ csrf_token() }}");
					});

					this.on("success", function(file, response)
					{
						window.location.reload();
					});
				}
			});

			var previewsUpload2 = $('#dzImage2').dropzone({
				url: "{{ route('item.images.upload', [$item->id, 'image2']) }}",
				clickable: true,
				acceptedFiles: ".jpg, .jpeg, .png, .gif, .bmp",
				paramName: "image2",
				init: function()
				{
					this.on("sending", function(file, xhr, formData)
					{
						formData.append("_token", "{{ csrf_token() }}");
					});

					this.on("success", function(file, response)
					{
						window.location.reload();
					});
				}
			});

			var previewsUpload3 = $('#dzImage3').dropzone({
				url: "{{ route('item.images.upload', [$item->id, 'image3']) }}",
				clickable: true,
				acceptedFiles: ".jpg, .jpeg, .png, .gif, .bmp",
				paramName: "image3",
				init: function()
				{
					this.on("sending", function(file, xhr, formData)
					{
						formData.append("_token", "{{ csrf_token() }}");
					});

					this.on("success", function(file, response)
					{
						window.location.reload();
					});
				}
			});
		});
	</script>
@stop