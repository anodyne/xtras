@extends('layouts.master')

@section('title')
	My Account
@stop

@section('content')
	<h1>My Account</h1>

	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="#" class="btn btn-small btn-default">Manage My Xtras</a>
		</div>
	</div>

	{{ Form::model($user, array('url' => 'profile')) }}
		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<div class="panel panel-warning">
					<div class="panel-title"><h4 class="panel-heading">Change Password</h4></div>

					<div class="form-group">
						<label>Password</label>
						{{ Form::password('password', array('class' => 'form-control')) }}
					</div>

					<div class="form-group">
						<label>Confirm Password</label>
						{{ Form::password('confirm_password', array('class' => 'form-control')) }}
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<div class="form-group">
					<label>Name</label>
					{{ Form::text('name', null, array('class' => 'form-control')) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<div class="form-group">
					<label>Email Address</label>
					{{ Form::text('email', null, array('type' => 'email', 'class' => 'form-control')) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="form-group">
					<label>My Profile URL</label>
					<p>{{ HTML::link("profile/{$user->slug}", URL::to("profile/{$user->slug}")) }}</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<div class="form-group">
					<label>Website</label>
					{{ Form::text('url', null, array('class' => 'form-control')) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 col-lg-6">
				<label>About Me</label>
				{{ Form::textarea('bio', null, array('class' => 'form-control', 'rows' => 5)) }}
				<p class="help-block">Tell users a little bit about yourself</p>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				{{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
			</div>
		</div>
	{{ Form::close() }}
@stop