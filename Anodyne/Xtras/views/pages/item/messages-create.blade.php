@extends('layouts.master')

@section('title')
	{{ $item->name }} - Create Message
@stop

@section('content')
	<h1>Create New Message <small>{{ $item->present()->name }}</small></h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('item.messages.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Back</a>
		</div>
	</div>

	{{ Form::open(['route' => ['item.messages.store', $item->user->username, $item->slug]]) }}
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label class="control-label">Message Type</label>
					{{ Form::select('type', $types, null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Message</label>
					{{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5]) }}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Preview</label>
					<p id="preview" class="alert alert-info"></p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label class="control-label">Expiration</label>
					{{ Form::text('expires', null, ['class' => 'form-control js-datepicker']) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				{{ Form::button('Create', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary']) }}
			</div>
		</div>
	{{ Form::close() }}
@stop

@section('styles')
	{{ HTML::style('css/datepicker.css') }}
@stop

@section('scripts')
	{{ HTML::script('js/datepicker.js') }}
	<script>
		$('[name="type"]').on('change', function(e)
		{
			$('#preview').removeClass('alert-info')
				.removeClass('alert-warning')
				.removeClass('alert-danger');

			$('#preview').addClass("alert-" + $(this).val());
		});

		$('[name="content"]').on('keyup', function(e)
		{
			$('#preview').html($(this).val());
		});

		$(function()
		{
			$('.js-datepicker').datepicker();
		});
	</script>
@stop