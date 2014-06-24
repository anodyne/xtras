@extends('layouts.master')

@section('title')
	Log In
@stop

@section('content')
	<div class="row">
		<div class="col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">
			<h1>Log In</h1>

			<p>AnodyneXtras is the one-stop-shop to find skins, MODs and rank sets created by Anodyne Productions and the wider Anodyne community. From here you can search for and download items to make your Nova sim more unique.</p>

			<hr>

			<div class="row">
				<div class="col-lg-12">
					{{ Form::open(array('url' => 'login')) }}
						<div class="form-group">
							<label>Email Address</label>
							{{ Form::text('email', null, array('type' => 'email', 'class' => 'form-control input-with-feedback input-lg')) }}
						</div>

						<div class="form-group">
							<label>Password</label>
							{{ Form::password('password', array('class' => 'form-control input-with-feedback input-lg')) }}
						</div>

						<div class="form-group">
							{{ Form::submit('Log In', array('class' => 'btn btn-lg btn-block btn-primary')) }}

							<a href="#" class="btn btn-block btn-link js-switch-register">Register Now</a>
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop