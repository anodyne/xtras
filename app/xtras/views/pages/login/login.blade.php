@extends('layouts.master')

@section('title')
	Log In
@stop

@section('content')
	<h1>Log In</h1>

	<p>AnodyneXtras is the one-stop-shop to find skins, MODs and rank sets created by Anodyne Productions and the wider Anodyne community. From here you can search for and download items to make your Nova sim more unique.</p>

	<div class="row">
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

					<a href="{{ URL::route('register') }}" class="btn btn-block btn-default">Register Now</a>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop