@extends('layouts.master')

@section('title')
	Advanced Search
@stop

@section('content')
	<h1>Advanced Search</h1>

	{{ Form::open(['route' => 'search.doAdvanced']) }}
		<div class="row">
			<div class="col-md-4 col-lg-4">
				<div class="form-group">
					<label>Type</label>
					<div>
					@foreach ($types as $id => $name)
						<div class="checkbox-inline">
							<label>{{ Form::checkbox('type[]', $id, true) }} {{ $name }}</label>
						</div>
					@endforeach
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-lg-4">
				<div class="form-group">
					<label>Product</label>
					<div>
					@foreach ($products as $id => $name)
						<div class="checkbox-inline">
							<label>{{ Form::checkbox('product[]', $id, true) }} {{ $name }}</label>
						</div>
					@endforeach
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-6">
				<div class="form-group">
					<label>Search Term</label>
					{{ Form::text('search', null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-6">
				{{ Form::button('Search', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary']) }}
			</div>
		</div>
	{{ Form::close() }}
@stop