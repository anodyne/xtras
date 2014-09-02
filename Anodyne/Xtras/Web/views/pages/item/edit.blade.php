@extends('layouts.master')

@section('title')
	{{ $item->name }} - Edit Xtra
@stop

@section('content')
	<h1>{{ $item->present()->name }} <small>Edit Xtra</small></h1>

	{{ Form::model($item, ['route' => ['item.update', $item->user->username, $item->slug], 'method' => 'put']) }}
		<div class="row">
			<div class="col-md-4 col-lg-4">
				<div class="form-group">
					<label>Name</label>
					{{ Form::text('name', null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2 col-lg-2">
				<div class="form-group">
					<label>Version</label>
					{{ Form::text('version', null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-6">
				<div class="form-group">
					<label>Description</label>
					{{ Form::textarea('desc', null, ['class' => 'form-control', 'rows' => 5]) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-6">
				<div class="form-group">
					<label>Support</label>
					{{ Form::text('support', null, ['class' => 'form-control']) }}
					<p class="help-block">You can specify an email address or website URL to use for support of this item if you want.</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-lg-8">
				<div class="form-group">
					<label>Installation Instructions</label>
					{{ Form::textarea('meta[installation]', null, ['class' => 'form-control', 'rows' => 8]) }}
					<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-lg-8">
				<div class="form-group">
					<label>Version History</label>
					{{ Form::textarea('meta[history]', null, ['class' => 'form-control', 'rows' => 8]) }}
					<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
				</div>
			</div>
		</div>

		{{ Form::hidden('user_id', $_currentUser->id) }}

		<div class="row">
			<div class="col-md-3 col-lg-3">
				{{ Form::button('Update Xtra', ['type' => 'submit', 'class' => 'btn btn-lg btn-block btn-primary']) }}
			</div>
			<div class="col-md-9 col-lg-9">
				<button class="btn btn-lg btn-link" disabled="disabled">Next Step: Upload Item Zip File</button>
			</div>
		</div>
	{{ Form::close() }}
@stop