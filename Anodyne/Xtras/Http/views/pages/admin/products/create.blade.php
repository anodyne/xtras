{{ Form::open(['route' => 'admin.products.store']) }}
	<div class="row">
		<div class="col-md-9">
			<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
				<label class="control-label">Name</label>
				{{ Form::text('name', null, ['class' => 'form-control']) }}
				{{ $errors->first('name', '<p class="help-block">:message</p>') }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label">Description</label>
				{{ Form::textarea('desc', null, ['class' => 'form-control', 'rows' => 5]) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">Display</label>
				<div>
					<label class="radio-inline">{{ Form::radio('display', (int) true, true) }} Yes</label>
					<label class="radio-inline">{{ Form::radio('display', (int) false) }} No</label>
				</div>
			</div>
		</div>
	</div>

	<div class="btn-toolbar">
		<div class="btn-group">
			{{ Form::button('Create', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}