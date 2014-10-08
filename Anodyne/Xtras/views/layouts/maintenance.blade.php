<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>AnodyneXtras</title>
		<meta name="description" content="AnodyneXtras is a one-stop-shop for skins, MODs, and rank sets for Anodyne Productions' Nova software.">
		<meta name="author" content="Anodyne Productions">
		<meta name="viewport" content="width=device-width">
		<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico?v1') }}">
		<link rel="apple-touch-icon-precomposed" href="{{ asset('apple-touch-icon.png') }}">

		<!--[if lt IE 9]>
		{{ HTML::script('js/html5shiv.js') }}
		<![endif]-->

		<link href="//fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
		<link href="//fonts.googleapis.com/css?family=Bitter:400,700" rel="stylesheet">
		<link href="//fonts.googleapis.com/css?family=Exo+2:500,500italic,600,600italic" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
		{{ HTML::style('css/style.css') }}
		{{ HTML::style('css/fonts.css') }}
	</head>
	<body>
		<div class="wrapper">
			<div class="visible-xs visible-sm">
				{{ View::make('pages.mobile') }}
			</div>
			<div class="visible-md visible-lg">
				<header>
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="brand text-center">AnodyneXtras</div>
							</div>
						</div>
					</div>
				</header>

				<section>
					<div class="container">
						@yield('content')
					</div>
				</section>
			</div>

			<div class="push"></div>
		</div>

		<footer>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h2>AnodyneXtras</h2>

						<p class="text-muted">Every game is unique; it has its own players, characters, missions, and driving force. Why shouldn't each game accurately reflect its distinctiveness through its look and feel and functionality? We've created AnodyneXtras as a one-stop-shop for skins, MODs, and rank sets for Nova so you can make your version of Nova as unique as the game being played with it.</p>

						<p class="text-muted">&copy; {{ Date::now()->year }} Anodyne Productions</p>
					</div>
				</div>
			</div>
		</footer>
	</body>
</html>