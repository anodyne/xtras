@extends('layouts.master')

@section('title')
	Create New Xtra
@stop

@section('content')
	<h1>Xtra Information <small>Create New Xtra</small></h1>

	{{ Form::open(['route' => 'xtra.store']) }}
		<div class="row">
			<div class="col-lg-3">
				<div class="form-group">
					<label>Type</label>
					{{ Form::select('type_id', $types, null, ['class' => 'form-control']) }}
				</div>
			</div>

			<div class="col-lg-3">
				<div class="form-group">
					<label>Product</label>
					{{ Form::select('product_id', $products, null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-4">
				<div class="form-group">
					<label>Name</label>
					{{ Form::text('name', null, ['class' => 'form-control']) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Description</label>
					{{ Form::textarea('desc', null, ['class' => 'form-control', 'rows' => 5]) }}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
					<label>Support</label>
					{{ Form::text('name', null, ['class' => 'form-control']) }}
					<p class="help-block">You can specify an email address or website URL to use for support of this item if you want.</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-8">
				<div class="form-group">
					<label>Installation Instructions</label>
					{{ Form::textarea('meta[installation]', null, ['class' => 'form-control', 'rows' => 8]) }}
					<p class="help-block">You can use Markdown to style your installation instructions.</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				{{ Form::button('Create', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary']) }}
			</div>
		</div>
	{{ Form::close() }}
@stop

@section('scripts')
	<script>

		$('[name="name"]').on('blur', function()
		{
			$.ajax({
				url: "{{ URL::route('xtra.ajax.checkName') }}",
				data: { name: $(this).val() },
				dataType: "json",
				success: function(data)
				{
					if (data.code == 1)
					{
						// Success
					}
					else
					{
						$('[name="name"]').val('');

						// Show an indicator
					}
				}
			});
		});

	</script>
@stop