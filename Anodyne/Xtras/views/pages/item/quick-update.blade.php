@extends('layouts.master')

@section('title')
	Quick Update Xtra
@stop

@section('content')
	<h1>Quick Update Xtra <small>{{ $item->present()->name }}</small></h1>

	{{ Form::model($item, []) }}
		<div class="row">
			<div class="col-md-2">
				<div class="form-group{{ ($errors->has('version')) ? ' has-error' : '' }}">
					<label class="control-label">New Version</label>
					{{ Form::text('version', null, ['class' => 'form-control']) }}
					{{ $errors->first('version', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					<label class="control-label">Updated Version History</label>
					{{ Form::textarea('metadata[history]', null, ['class' => 'form-control', 'rows' => 8]) }}
					<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
				</div>
			</div>
		</div>

		{{ alert('warning', "You must change the version number before you can upload the new zip file.") }}

		<p><div id="dzZip" class="dropzone"></div></p>

		<div class="hide" id="buttons">
			<div class="btn-toolbar">
				<div class="btn-group">
					<a href="{{ route('account.xtras') }}" class="btn btn-lg btn-primary">My Xtras</a>
				</div>
			</div>
		</div>
	{{ Form::close() }}
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

		$('[name="version"]').on('change', function(e)
		{
			$.ajax({
				url: "{{ route('item.ajax.updateField') }}",
				type: "POST",
				data: {
					item: "{{ $item->id }}",
					field: "version",
					value: $('[name="version"]').val(),
					'_token': "{{ csrf_token() }}"
				}
			});
		});

		$('[name="metadata[history]"]').on('change', function(e)
		{
			$.ajax({
				url: "{{ route('item.ajax.updateField') }}",
				type: "POST",
				data: {
					item: "{{ $item->id }}",
					field: "metadata.history",
					value: $('[name="metadata[history]"]').val(),
					'_token': "{{ csrf_token() }}"
				}
			});
		});
	</script>
@stop