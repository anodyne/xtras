@extends('layouts.master')

@section('title')
	Create New Xtra
@stop

@section('content')
	<h1>Xtra Information <small>Create New Xtra</small></h1>

	<p>Use the form below to enter the basic information for your new xtra. This is information that users will see when viewing your xtra and that will be used when users are searching for xtras. Once the item is created, you'll be able to upload the zip file and any preview images you want.</p>

	<hr>

	{{ Form::open(['route' => 'item.store']) }}
		<div class="row">
			<div class="col-md-3 col-lg-3">
				<div class="form-group{{ ($errors->has('type_id')) ? ' has-error' : '' }}">
					<label class="control-label">Type</label>
					{{ Form::select('type_id', $types, null, ['class' => 'form-control']) }}
					{{ $errors->first('type_id', '<p class="help-block">:message</p>') }}
				</div>
			</div>

			<div class="col-md-3 col-lg-3">
				<div class="form-group{{ ($errors->has('product_id')) ? ' has-error' : '' }}">
					<label class="control-label">Product</label>
					{{ Form::select('product_id', $products, null, ['class' => 'form-control']) }}
					{{ $errors->first('product_id', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-lg-4">
				<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
					<label class="control-label">Name</label>
					{{ Form::text('name', null, ['class' => 'form-control']) }}
					{{ $errors->first('name', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2 col-lg-2">
				<div class="form-group{{ ($errors->has('version')) ? ' has-error' : '' }}">
					<label class="control-label">Version</label>
					{{ Form::text('version', '1.0', ['class' => 'form-control']) }}
					{{ $errors->first('version', '<p class="help-block">:message</p>') }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-6">
				<div class="form-group">
					<label class="control-label">Description</label>
					{{ Form::textarea('desc', null, ['class' => 'form-control', 'rows' => 5]) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-6">
				<div class="form-group">
					<label class="control-label">Support</label>
					{{ Form::text('support', null, ['class' => 'form-control']) }}
					<p class="help-block">You can specify an email address or website URL to use for support of this item if you want.</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-lg-8">
				<div class="form-group">
					<label class="control-label">Installation Instructions</label>
					{{ Form::textarea('meta[installation]', null, ['class' => 'form-control', 'rows' => 8]) }}
					<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-lg-8">
				<div class="form-group">
					<label class="control-label">Version History</label>
					{{ Form::textarea('meta[history]', null, ['class' => 'form-control', 'rows' => 8]) }}
					<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
				</div>
			</div>
		</div>

		{{ Form::hidden('slug', '') }}
		{{ Form::hidden('user_id', $_currentUser->id) }}

		<div class="row">
			<div class="col-md-3 col-lg-3">
				{{ Form::button('Create and Continue', ['type' => 'submit', 'class' => 'btn btn-lg btn-block btn-primary']) }}
			</div>
			<div class="col-md-9 col-lg-9">
				<button class="btn btn-lg btn-link" disabled="disabled">Next Step: Upload Item Zip File</button>
			</div>
		</div>
	{{ Form::close() }}
@stop

@section('scripts')

	<script>

		$('[name="name"]').on('change', function()
		{
			var value = $(this).val();

			$.ajax({
				url: "{{ URL::route('item.ajax.checkName') }}",
				type: "POST",
				dataType: "json",
				data: { name: value },
				success: function(data)
				{
					if (data.code == 0)
					{
						alert("You already have an xtra with that name. Please choose a different name!");
						$('[name="name"]').val('');
					}
				}
			});
		});

	</script>

@stop