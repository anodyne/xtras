@extends('layouts.master')

@section('title')
	Log In
@stop

@section('content')
	<h1>Log In</h1>

	<p>AnodyneXtras is the one-stop-shop to find skins, MODs and rank sets created by Anodyne Productions and the wider Anodyne community. From here you can search for and download items to make your Nova sim more unique.</p>

	<div class="row" id="loginForm">
		<div class="col-lg-6 col-offset-3">
			{{ Form::open(array('url' => 'login')) }}
				<div class="form-group">
					<label>Email Address</label>
					{{ Form::text('email', null, array('type' => 'email', 'class' => 'form-control input-with-feedback')) }}
				</div>

				<div class="form-group">
					<label>Password</label>
					{{ Form::password('password', array('class' => 'form-control input-with-feedback')) }}
				</div>

				<div class="form-group">
					{{ Form::submit('Log In', array('class' => 'btn btn-large btn-block btn-primary')) }}

					<a href="#" class="btn btn-block btn-default js-switch-register">Register Now</a>
				</div>
			{{ Form::close() }}
		</div>
	</div>

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

@section('javascript')
	<script type="text/javascript">
		$(document).on('click', '.js-switch-register', function()
		{
			$('#loginForm').addClass('hide');
			$('#registerForm').removeClass('hide');
		});

		$(document).on('click', '.js-switch-login', function()
		{
			$('#registerForm').addClass('hide');
			$('#loginForm').removeClass('hide');
		});
	</script>
@stop