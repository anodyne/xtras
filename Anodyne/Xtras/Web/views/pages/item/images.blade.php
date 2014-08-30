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