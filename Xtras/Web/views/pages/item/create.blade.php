@extends('layouts.master')

@section('title')
	Create New Xtra
@stop

@section('content')
	<h1>Xtra Information <small>Create New Xtra</small></h1>

	<p>Use the form below to enter the basic information for your new xtra. This is information that users will see when viewing your xtra and that will be used when users are searching for xtras. Once the item is created, you'll be able to upload the zip file and any preview images you want.</p>

	<hr>

	{{ Form::open(['route' => 'xtra.store']) }}
		<div class="row">
			<div class="col-lg-3">
				<div class="form-group">
					<label>Type</label>
					{{ Form::select('type_id', $types, null, ['class' => 'form-control']) }}
				</div>
			</div>

			<div class="col-lg-3">
				<div class="form-group">
					<label>Product</label>
					{{ Form::select('product_id', $products, null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label>Name</label>
					{{ Form::text('name', null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Description</label>
					{{ Form::textarea('desc', null, ['class' => 'form-control', 'rows' => 5]) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Support</label>
					{{ Form::text('support', null, ['class' => 'form-control']) }}
					<p class="help-block">You can specify an email address or website URL to use for support of this item if you want.</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-8">
				<div class="form-group">
					<label>Installation Instructions</label>
					{{ Form::textarea('meta[installation]', null, ['class' => 'form-control', 'rows' => 8]) }}
					<p class="help-block">You can use Markdown to style your installation instructions.</p>
				</div>
			</div>
		</div>

		{{ Form::hidden('slug', '') }}

		<div class="row">
			<div class="col-lg-3">
				{{ Form::button('Create and Continue', ['type' => 'submit', 'class' => 'btn btn-lg btn-block btn-primary']) }}
			</div>
			<div class="col-lg-9">
				<button class="btn btn-lg btn-link" disabled="disabled">Next Step: Upload Files and Preview Images {{ $_icons['next'] }}</button>
			</div>
		</div>
	{{ Form::close() }}
@stop