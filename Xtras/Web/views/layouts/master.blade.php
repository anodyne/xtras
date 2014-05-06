<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>AnodyneXtras &bull; @yield('title')</title>
		<meta name="description" content="AnodyneXtras is a one-stop-shop for skins, MODs, and rank sets for Anodyne Productions' Nova software.">
		<meta name="author" content="Anodyne Productions">
		<meta name="viewport" content="width=device-width">
		<link rel="icon" type="image/x-icon" href="{{ URL::asset('favicon.ico?v1') }}">
		<link rel="apple-touch-icon-precomposed" href="{{ URL::asset('apple-touch-icon.png') }}">

		<!--[if lt IE 9]>
		{{ HTML::script('js/html5shiv.js') }}
		<![endif]-->

		@if (App::environment() == 'production')
			<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
			<link href="http://fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet">
			<link href="http://fonts.googleapis.com/css?family=Exo+2:500,500italic,600,600italic" rel="stylesheet">
			<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
		@else
			<link href="http://localhost/global/bootstrap/3.1/css/bootstrap.min.css" rel="stylesheet">
		@endif

		{{ HTML::style('css/style.css') }}
		{{ HTML::style('css/fonts.css') }}
		@yield('styles')
	</head>
	<body>
		<nav class="nav-main">
			<div class="container">
				<ul class="pull-right">
					<li><a href="#">Contact</a></li>
				</ul>

				<ul>
					<li><a href="http://anodyne-productions.com">Anodyne<div class="arrow"></div></a></li>
					<li><a href="http://anodyne-productions.com/nova">Nova<div class="arrow"></div></a></li>
					<li><a href="{{ URL::route('home') }}" class="active">Xtras<div class="arrow"></div></a></li>
					<li><a href="http://forums.anodyne-productions.com">Forums<div class="arrow"></div></a></li>
					<li><a href="http://help.anodyne-productions.com">Help<div class="arrow"></div></a></li>
					<li><a href="http://learn.anodyne-productions.com">Learn<div class="arrow"></div></a></li>
				</ul>
			</div>
		</nav>

		<header>
			<div class="container">
				<div class="row">
					<div class="col-lg-3">
						<div class="brand">AnodyneXtras</div>
					</div>

					@if (Auth::check())
						<div class="col-lg-5">
							<nav class="nav-sub">
								<ul>
									<li><a href="#">Skins</a></li>
									<li><a href="#">Ranks</a></li>
									<li><a href="#">MODs</a></li>
								</ul>
							</nav>
						</div>

						<div class="col-lg-4">
							<div class="header-search">
								<div class="input-group">
									{{ Form::text('search', null, array('placeholder' => 'Search Xtras', 'class' => 'input-sm form-control search-field')) }}
									<span class="input-group-btn">{{ Form::button('Search', array('class' => 'btn btn-default btn-sm')) }}</span>
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		</header>

		<section>
			<div class="container">
				@if (Session::has('flashMessage'))
					{{ partial('alert', ['type' => Session::get('flashStatus'), 'content' => Session::get('flashMessage')]) }}
				@endif

				@yield('content')
			</div>
		</section>

		@if (App::environment() == 'production')
			<!--[if lt IE 9]>
				<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
			<![endif]-->
			<!--[if gte IE 9]><!-->
				<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
			<!--<![endif]-->

			<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		@else
			<!--[if lt IE 9]>
				<script src="http://localhost/global/jquery/jquery-1.11.1.min.js"></script>
			<![endif]-->
			<!--[if gte IE 9]><!-->
				<script src="http://localhost/global/jquery/jquery-2.1.1.min.js"></script>
			<!--<![endif]-->

			<script src="http://localhost/global/bootstrap/3.1/js/bootstrap.min.js"></script>
		@endif
	</body>
</html>