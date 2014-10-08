@extends('layouts.master')

@section('title')
	User Size Report
@stop

@section('content')
	<h1>User Size Report</h1>

	{{ $items->links() }}

	<div class="data-table data-table-striped data-table-bordered">
	@foreach ($items as $item)
		<div class="row">
			<div class="col-md-6">
				<p class="lead">{{ $item['user']->present()->name }}</p>
			</div>
			<div class="col-md-3">
				<p>{{ $item['prettySize'] }}</p>
			</div>
			<div class="col-md-3">
				<div class="btn-toolbar pull-right">
					<div class="btn-group">
						<a href="{{ route('account.profile', [$item['user']->username]) }}" class="btn btn-default">Author</a>
					</div>
				</div>
			</div>
		</div>
	@endforeach
	</div>

	{{ $items->links() }}
@stop