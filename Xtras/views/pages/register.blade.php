@extends('layouts.master')

@section('title')
	Register
@stop

@section('content')
	<h1>Register</h1>

	<div class="row hide" id="registerForm">
		<div class="col-lg-6 col-offset-3">
			{{ Form::open(array('url' => 'register')) }}
				<div class="form-group">
					<label>Name</label>
					{{ Form::text('name', null, array('class' => 'form-control input-with-feedback')) }}
				</div>

				<div class="form-group">
					<label>Email Address</label>
					{{ Form::text('email', null, array('type' => 'email', 'class' => 'form-control input-with-feedback')) }}
				</div>

				<div class="form-group">
					<label>Password</label>
					{{ Form::password('password', array('class' => 'form-control input-with-feedback')) }}
				</div>

				<div class="form-group">
					{{ Form::submit('Register', array('class' => 'btn btn-large btn-block btn-primary')) }}

					<a href="#" class="btn btn-block btn-default js-switch-login">Log In Now</a>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop