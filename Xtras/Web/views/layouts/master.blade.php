<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>@yield('title') &bull; AnodyneXtras</title>
		<meta name="description" content="AnodyneXtras is a one-stop-shop for skins, MODs, and rank sets for Anodyne Productions' Nova software.">
		<meta name="author" content="Anodyne Productions">
		<meta name="viewport" content="width=device-width">
		<link rel="icon" type="image/x-icon" href="{{ URL::asset('favicon.ico?v2') }}">
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
		<div class="wrapper">
			<div class="visible-xs visible-sm">
				{{ View::make('pages.mobile') }}
			</div>
			<div class="visible-md visible-lg">
				<nav class="nav-main">
					<div class="container">
						<ul class="pull-right">
							<li><a href="#">Contact</a></li>

							@if (Auth::check())
								<li class="dropdown">
									<a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="user-icon">{{ $_icons['user'] }}</span> {{ Auth::user()->present()->name }} <span class="caret"></span></a>
									<ul class="dropdown-menu dropdown-menu-right dd">
										<li><a href="{{ URL::route('xtras', [$_currentUser->slug]) }}">My Xtras</a></li>
										<li><a href="{{ URL::route('xtra.create') }}">Create New Xtra</a></li>
										<li class="divider"></li>
										<li><a href="{{ URL::route('profile', [$_currentUser->slug]) }}">My Profile</a></li>
										<li><a href="{{ URL::route('account', [$_currentUser->slug]) }}">Edit My Profile</a></li>
										<li class="divider"></li>
										<li><a href="{{ URL::route('logout') }}">Logout</a></li>
									</ul>
								</li>
							@endif
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
							<div class="col-md-3 col-lg-3">
								<a href="{{ URL::route('home') }}" class="brand">AnodyneXtras</a>
							</div>

							@if (Auth::check())
								<div class="col-md-5 col-lg-5">
									<nav class="nav-sub">
										<ul>
											<li><a href="{{ URL::route('skins') }}">Skins</a></li>
											<li><a href="{{ URL::route('mods') }}">MODs</a></li>
											<li><a href="{{ URL::route('ranks') }}">Ranks</a></li>
											<li><a href="{{ URL::route('xtras') }}">My Xtras</a></li>
										</ul>
									</nav>
								</div>

								<div class="col-md-4 col-lg-4">
									{{ Form::open(['route' => 'search.do']) }}
										<div class="header-search">
											<div class="input-group">
												{{ Form::text('search', null, array('placeholder' => 'Search Xtras', 'class' => 'input-sm form-control search-field')) }}
												<span class="input-group-btn">{{ Form::button('Search', array('class' => 'btn btn-default btn-sm', 'type' => 'submit')) }}</span>
											</div>
										</div>
									{{ Form::close() }}
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
			</div>

			<div class="push"></div>
		</div>

		<footer class="visible-md visible-lg">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-lg-8">
						<h2>AnodyneXtras</h2>

						<p class="text-muted">Every game is unique in its own right. It has its own players, characters, mission, and driving force. Why shouldn't each game be able to accurately reflect its distinctiveness through its look and feel and functionality? We don't think that should be a hinderance and we've created AnodyneXtras as a one-stop-shop for skins, MODs, and rank sets for Nova so you can make your copy of Nova as unique as the game being played on it.</p>

						<p class="text-muted">&copy; {{ Date::now()->year }} Anodyne Productions</p>
					</div>
					<div class="col-md-3 col-lg-2">
						<ul class="list-unstyled">
							<li><a href="{{ URL::route('home') }}">Home</a></li>

							@if (Auth::check())
								<li><a href="{{ URL::route('xtras') }}">My Xtras</a></li>
								<li><a href="{{ URL::route('skins') }}">Skins</a></li>
								<li><a href="{{ URL::route('ranks') }}">Ranks</a></li>
								<li><a href="{{ URL::route('mods') }}">MODs</a></li>
							@endif
						</ul>
					</div>
					<div class="col-md-3 col-lg-2">
						<ul class="list-unstyled">
							<li><a href="{{ URL::route('policies') }}">Site Policies</a></li>
							<li><a href="#">Contact</a></li>
							<li><a href="http://anodyne-productions.com">Anodyne Productions</a></li>
						</ul>
					</div>
				</div>
			</div>
		</footer>

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
		<script>
			$(document).ready(function()
			{
				$('.tooltip-bottom').tooltip({ position: "bottom" });
				$('.tooltip-top').tooltip({ position: "top" });
			});
		</script>
		@yield('scripts')
	</body>
</html>