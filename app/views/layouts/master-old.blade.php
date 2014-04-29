<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>AnodyneXtras &bull; @yield('title')</title>

		{{ HTML::style('css/bootstrap.min.css') }}
		{{ HTML::style('css/style.css') }}
		{{ HTML::style('css/fonts.css') }}
	</head>
	<body>
		<div class="container">
			<h1 class="ap"><a href="http://anodyne-productions.com">anodyne<span class="light">productions</span></a></h1>

			<div id="wrapper">
				<nav class="nav-main">
					<div class="row">
						<div class="col-lg-2">
							<a href="{{ URL::route('home') }}" class="brand">XTRAS</a>
						</div>
						<div class="col-lg-6">
							<ul class="nav-items">
								<li{{ (Route::is('skins') or Route::is('skin')) ? ' class="active"' : '' }}>
									<a href="{{ URL::route('skins') }}">Skins</a>
								</li>
								<li{{ (Route::is('ranks') or Route::is('rank')) ? ' class="active"' : '' }}>
									<a href="{{ URL::route('ranks') }}">Ranks</a>
								</li>
								<li{{ (Route::is('mods') or Route::is('mod')) ? ' class="active"' : '' }}>
									<a href="{{ URL::route('mods') }}">MODs</a>
								</li>
							</ul>
						</div>
						<div class="col-lg-4">
							<div class="right-col">
								<div class="row">
									<div class="col-lg-10">
										{{ Form::text('search', null, ['class' => 'input-small form-control', 'placeholder' => 'Search for Xtras']) }}
									</div>
									<div class="col-lg-2">
										@if (Auth::check())
											<div class="icn-size-16 text-left icn-opacity-75"><span class="icn" data-icon="p"></span></div>
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</nav>

				<section>
					<div class="row">
						<div class="col-lg-12">@yield('content')</div>
					</div>
				</section>
			</div>
		</div>

		<!--[if lt IE 9]>
			<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<![endif]-->
		<!--[if gte IE 9]><!-->
			<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
		<!--<![endif]-->

		{{ HTML::script('js/bootstrap.min.js') }}

		<script type="text/javascript">
			$(document).ready(function()
			{
				$('.tooltip-top').tooltip();
			});
		</script>

		@yield('javascript')
	</body>
</html>