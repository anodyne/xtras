@extends('layouts.master')

@section('title')
	Home
@stop

@section('content')
	<h1>AnodyneXtras</h1>

	<p>AnodyneXtras is the one-stop-shop to find skins, MODs and rank sets created by Anodyne Productions and the wider Anodyne community. From here you can search for and download items to make your Nova sim more unique.</p>

	<div class="row">
		<div class="col-lg-6">
			<h2>Latest Updates</h2>

			@if ($updated->count() > 0)
				@foreach ($updated as $u)
					{{ partial('media', $u) }}
				@endforeach
			@else
				{{ partial('alert', array('content' => "No updates available")) }}
			@endif
		</div>

		<div class="col-lg-6">
			<h2>Newest Xtras</h2>

			@if ($new->count() > 0)
				@foreach ($new as $n)
					{{ partial('media', $n) }}
				@endforeach
			@else
				{{ partial('alert', array('content' => "No xtras available")) }}
			@endif
		</div>
	</div>
@stop