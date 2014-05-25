@extends('layouts.master')

@section('title')
	Home
@stop

@section('content')
	<div id="newest">
		<a href="#" data-target="updated" class="btn btn-sm btn-default pull-right xtra-toggle">See Recently Updated Xtras</a>

		<h2>Newest Xtras</h2>

		<div class="row">
			@foreach ($new as $item)
				<div class="col-sm-6 col-md-6 col-lg-4">
					{{ View::make('partials.media')->withItem($item) }}
				</div>
			@endforeach
		</div>
	</div>
	
	<div id="updated" class="hide">
		<a href="#" data-target="newest" class="btn btn-sm btn-default pull-right xtra-toggle">See Newest Xtras</a>

		<h2>Recently Updated Xtras</h2>

		<div class="row">
			@foreach ($updated as $item)
				<div class="col-sm-6 col-md-6 col-lg-4">
					{{ View::make('partials.media')->withItem($item) }}
				</div>
			@endforeach
		</div>
	</div>
@stop

@section('scripts')
	{{ HTML::script('js/jquery.ui.effect.min.js') }}
	<script>

		$('.xtra-toggle').on('click', function(e)
		{
			e.preventDefault();

			var target = $(this).data('target');

			if (target == 'newest')
			{
				$('#updated').addClass('hide', {
					duration: 500,
					queue: false
				});
				$('#newest').removeClass('hide', {
					duration: 500,
					queue: false
				});
			}
			else if (target == 'updated')
			{
				$('#newest').addClass('hide', {
					duration: 500,
					queue: false
				});
				$('#updated').removeClass('hide', {
					duration: 500,
					queue: false
				});
			}
		});

	</script>
@stop