@extends('layouts.master')

@section('title')
	Register
@stop

@section('content')
	<div class="row">
		<div class="col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
			<h1>Register</h1>

			<p>AnodyneXtras is the one-stop-shop to find skins, MODs and rank sets created by Anodyne Productions and the wider Anodyne community. In order to share, search, and download xtras for you game, you'll need to first take a few seconds to register.</p>

			<hr>

			{{ Form::open(['route' => 'register.do']) }}
				<div class="form-group">
					<label>Name</label>
					{{ Form::text('name', null, ['class' => 'form-control input-with-feedback']) }}
					<p class="help-block">Choose wisely! This is the name that will be used as your profile name and to associate all your xtras with your account.</p>
					{{ $errors->first('name', '<p class="help-block">:message</p>') }}
				</div>

				<div class="form-group">
					<label>Email Address</label>
					{{ Form::text('email', null, ['type' => 'email', 'class' => 'form-control input-with-feedback']) }}
					{{ $errors->first('email', '<p class="help-block">:message</p>') }}
				</div>

				<div class="form-group">
					<label>Password</label>
					{{ Form::password('password', ['class' => 'form-control input-with-feedback']) }}
					{{ $errors->first('password', '<p class="help-block">:message</p>') }}
				</div>

				<div class="form-group">
					<label>Confirm Password</label>
					{{ Form::password('password_confirm', ['class' => 'form-control input-with-feedback']) }}
					{{ $errors->first('password_confirm', '<p class="help-block">:message</p>') }}
				</div>

				<div class="form-group">
					<label>Spam-Be-Gone</label>
					<p class="help-block">In order to prevent spam, please type in the following number to the field below: <strong>{{ $confirmNumber }}</strong>.</p>
					{{ Form::text('confirm', null, ['class' => 'form-control input-with-feedback']) }}
					{{ $errors->first('confirm', '<p class="help-block">:message</p>') }}
				</div>

				<div class="form-group">
					{{ Form::button('Register', ['type' => 'submit', 'class' => 'btn btn-lg btn-block btn-primary']) }}

					<a href="{{ route('login') }}" class="btn btn-block btn-link">Log In Now</a>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop