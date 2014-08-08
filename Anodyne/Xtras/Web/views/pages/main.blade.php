@extends('layouts.master')

@section('title')
	Home
@stop

@section('content')
	<div id="newest">
		<a href="#" data-target="updated" class="btn btn-sm btn-default pull-right xtra-toggle">See Recently Updated Xtras</a>

		<h1>Newest Xtras</h1>

		<div class="row">
			@foreach ($new as $item)
				<div class="col-md-4 col-lg-4">
					{{ View::make('partials.media')->withItem($item) }}
				</div>
			@endforeach
		</div>
	</div>
		
	<div id="updated" class="hide">
		<a href="#" data-target="newest" class="btn btn-sm btn-default pull-right xtra-toggle">See Newest Xtras</a>

		<h1>Recently Updated Xtras</h1>

		<div class="row">
			@foreach ($updated as $item)
				<div class="col-md-4 col-lg-4">
					{{ View::make('partials.media')->withItem($item) }}
				</div>
			@endforeach
		</div>
	</div>
@stop

@section('scripts')
	<script>
		$('.xtra-toggle').on('click', function(e)
		{
			e.preventDefault();

			var target = $(this).data('target');

			if (target == 'newest')
			{
				$('div#updated').addClass('hide');
				$('div#newest').removeClass('hide');
			}
			
			if (target == 'updated')
			{
				$('div#newest').addClass('hide');
				$('div#updated').removeClass('hide');
			}
		});
	</script>
@stop