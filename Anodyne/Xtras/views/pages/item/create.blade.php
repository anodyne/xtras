@extends('layouts.master')

@section('title')
	Create New Xtra
@stop

@section('content')
	<h1>Xtra Information <small>Create New Xtra</small></h1>

	<p>Use the form below to enter the basic information for your new Xtra. This is information that users will see when viewing your Xtra and that will be used when users are searching for Xtras. Once the Xtra is created, you'll be able to upload the zip file and any preview images you want.</p>

	<hr>

	{{ Form::open(['route' => 'item.store']) }}
		<div class="row">
			<div class="col-md-3">
				<div class="form-group{{ ($errors->has('type_id')) ? ' has-error' : '' }}">
					<label class="control-label">Type</label>
					{{ Form::select('type_id', $types, null, ['class' => 'form-control']) }}
					{{ $errors->first('type_id', '<p class="help-block">:message</p>') }}
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group{{ ($errors->has('product_id')) ? ' has-error' : '' }}">
					<label class="control-label">Product</label>
					{{ Form::select('product_id', $products, null, ['class' => 'form-control']) }}
					{{ $errors->first('product_id', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
					<label class="control-label">Name</label>
					{{ Form::text('name', null, ['class' => 'form-control']) }}
					{{ $errors->first('name', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<div class="form-group{{ ($errors->has('version')) ? ' has-error' : '' }}">
					<label class="control-label">Version</label>
					{{ Form::text('version', '1.0', ['class' => 'form-control']) }}
					{{ $errors->first('version', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Description</label>
					{{ Form::textarea('desc', null, ['class' => 'form-control', 'rows' => 5]) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Support</label>
					{{ Form::text('support', null, ['class' => 'form-control']) }}
					<p class="help-block">You can specify an email address or website URL to use for support of this item if you want. If you don't enter anything here, your account email address will be used.</p>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">&nbsp;</label>
					<div>
						<span id="supportEmail">{{ label('muted', 'Email address') }}</span>
						<span id="supportWebsite">{{ label('muted', 'Website') }}</span>
						<span id="supportInvalid" class="hide">{{ label('danger', 'Invalid Support Option') }}</span>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					<label class="control-label">Installation Instructions</label>
					{{ Form::textarea('metadata[installation]', null, ['class' => 'form-control', 'rows' => 8]) }}
					<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8">
				<div class="form-group">
					<label class="control-label">Version History</label>
					{{ Form::textarea('metadata[history]', null, ['class' => 'form-control', 'rows' => 8]) }}
					<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
				</div>
			</div>
		</div>

		{{ Form::hidden('slug', '') }}

		<div class="btn-toolbar">
			<div class="btn-group">
				{{ Form::button('Create and go to Upload Zip File', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary']) }}
			</div>
			<div class="btn-group">
				<a href="{{ route('account.xtras') }}" class="btn btn-lg btn-default">Cancel</a>
			</div>
		</div>
	{{ Form::close() }}
@stop

@section('scripts')
	<script>
		$('[name="name"]').on('change', function()
		{
			$.ajax({
				url: "{{ URL::to('item/ajax/checkName') }}/" + $(this).val(),
				dataType: "json",
				success: function(data)
				{
					if (data.code == 0)
					{
						alert("You already have an Xtra with that name. Please choose a different name!");
						$('[name="name"]').val('');
					}
				}
			});
		});

		$('[name="support"]').on('change', function(e)
		{
			var value = $('[name="support"]').val();
			var email = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			var url = /^[a-z]+:\/\//i;

			// Reset everything
			$('#supportInvalid').addClass('hide');
			$('#supportEmail .label').removeClass('label-default').addClass('label-muted');
			$('#supportWebsite .label').removeClass('label-default').addClass('label-muted');

			// Test for a valid email address format
			if (email.test(value))
				$('#supportEmail .label').removeClass('label-muted').addClass('label-default');

			// Test for a valid URL format
			if (url.test(value))
				$('#supportWebsite .label').removeClass('label-muted').addClass('label-default');

			// If there's something in the field and it doesn't validate, error out
			if (value != "" && ! email.test(value) && ! url.test(value))
				$('#supportInvalid').removeClass('hide');
		});
	</script>
@stop