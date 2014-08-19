@extends('layouts.master')

@section('title')
	{{ $type }}
@stop

@section('content')
	<h1>{{ $type }}</h1>

	@if ($items->getTotal() > 0)
		{{ $items->links() }}

		<div class="row">
			@foreach ($items as $item)
				<div class="col-md-4 col-lg-4">
					{{ View::make('partials.media')->withItem($item) }}
				</div>
			@endforeach
		</div>

		{{ $items->links() }}
	@else
	@endif
@stop