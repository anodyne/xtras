@extends('layouts.master')

@section('title')
	Edit Account
@stop

@section('content')
	<h1>Edit Account <small>{{ $user->present()->name }}</small></h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="#" class="btn btn-default">Change Password</a>
		</div>
	</div>

	{{ Form::model($user, ['route' => ['account.edit', $user->id], 'method' => 'put']) }}
		<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label>Name</label>
					{{ Form::text('name', null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>

		<div class="row">
			@if ($_currentUser->access() > 1)
				<div class="col-lg-4">
					<div class="form-group">
						<label>Profile Slug</label>
						{{ Form::text('slug', null, ['class' => 'form-control']) }}
					</div>
				</div>
			@else
				<div class="col-lg-8">
					<div class="form-group">
						<label>Profile Link</label>
						<p class="form-control-static">{{ URL::route('profile', [$user->slug]) }}</p>
					</div>
				</div>
			@endif
		</div>

		<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label>Email Address</label>
					{{ Form::email('email', null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label>Personal Website URL</label>
					{{ Form::text('url', null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Bio</label>
					{{ Form::textarea('bio', null, ['class' => 'form-control', 'rows' => 8]) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				{{ Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary']) }}
			</div>
		</div>
	{{ Form::close() }}
@stop