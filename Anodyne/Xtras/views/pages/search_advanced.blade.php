@extends('layouts.master')

@section('title')
	Advanced Search
@stop

@section('content')
	<h1>Advanced Search</h1>

	{{ Form::open(['route' => 'search.doAdvanced', 'method' => 'GET']) }}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="control-label">Type</label>
					<div>
					@foreach ($types as $id => $name)
						<label class="checkbox-inline">{{ Form::checkbox('t[]', $id, true) }} {{ $name }}</label>
					@endforeach
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Product</label>
					<div>
					@foreach ($products as $id => $name)
						<label class="checkbox-inline">{{ Form::checkbox('p[]', $id, true) }} {{ $name }}</label>
					@endforeach
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label">Search Term</label>
					{{ Form::text('q', null, ['class' => 'form-control input-lg']) }}
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label>&nbsp;</label>
					{{ Form::button('Search', ['type' => 'submit', 'class' => 'btn btn-lg btn-block btn-primary']) }}
				</div>
			</div>
		</div>
	{{ Form::close() }}
@stop