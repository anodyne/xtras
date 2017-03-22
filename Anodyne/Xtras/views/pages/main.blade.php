@extends('layouts.master')

@section('title')
	Home
@stop

@section('content')
	<div id="newest">
		<div class="visible-xs visible-sm">
			<a href="#" data-target="updated" class="btn btn-lg btn-block btn-primary-alt xtra-toggle">See Recently Updated Xtras</a>
		</div>
		<div class="pull-right visible-md visible-lg">
			<a href="#" data-target="updated" class="btn btn-sm btn-primary-alt xtra-toggle">See Recently Updated Xtras</a>
		</div>

		<h1>Newest Xtras</h1>

		@if (count($new) > 0)
			<div class="row">
				@foreach ($new as $item)
					<div class="col-md-4">
						{{ View::make('partials.media')->withItem($item)->render() }}
					</div>
				@endforeach
			</div>
		@else
			{{ alert('warning', "No recently created Xtras found.") }}
		@endif
	</div>
		
	<div id="updated" class="hide">
		<div class="visible-xs visible-sm">
			<a href="#" data-target="newest" class="btn btn-lg btn-block btn-primary-alt xtra-toggle">See Newest Xtras</a>
		</div>
		<div class="pull-right visible-md visible-lg">
			<a href="#" data-target="newest" class="btn btn-sm btn-primary-alt xtra-toggle">See Newest Xtras</a>
		</div>

		<h1>Recently Updated Xtras</h1>

		@if (count($updated) > 0)
			<div class="row">
				@foreach ($updated as $item)
					<div class="col-md-4">
						{{ View::make('partials.media')->withItem($item)->render() }}
					</div>
				@endforeach
			</div>
		@else
			{{ alert('warning', "No recently updated Xtras found.") }}
		@endif
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