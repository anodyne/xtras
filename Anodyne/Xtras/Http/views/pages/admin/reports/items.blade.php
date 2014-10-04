@extends('layouts.master')

@section('title')
	Item Size Report
@stop

@section('content')
	<h1>Item Size Report</h1>

	{{ $items->links() }}

	<div class="data-table data-table-striped data-table-bordered">
	@foreach ($items as $item)
		<div class="row">
			<div class="col-md-5">
				<p class="lead">{{ $item['item']->present()->name }}</p>
			</div>
			<div class="col-md-2">
				<p>
					{{ $item['item']->present()->productAsLabel }}
					{{ $item['item']->present()->typeAsLabel }}
				</p>
			</div>
			<div class="col-md-2">
				<p>{{ $item['prettySize'] }}</p>
			</div>
			<div class="col-md-3">
				<div class="btn-toolbar pull-right">
					<div class="btn-group">
						<a href="{{ route('account.profile', [$item['item']->user->username]) }}" class="btn btn-default">Author</a>
					</div>
					<div class="btn-group">
						<a href="{{ route('item.show', [$item['item']->user->username, $item['item']->slug]) }}" class="btn btn-default">Xtra</a>
					</div>
				</div>
			</div>
		</div>
	@endforeach
	</div>

	{{ $items->links() }}
@stop