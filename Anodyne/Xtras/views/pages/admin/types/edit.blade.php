{{ Form::model($type, ['route' => ['admin.types.update', $type->id], 'method' => 'put']) }}
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
		<div class="col-md-6">
			<div class="form-group">
				<label class="control-label">Display</label>
				<div>
					<label class="radio-inline">{{ Form::radio('display', (int) true) }} Yes</label>
					<label class="radio-inline">{{ Form::radio('display', (int) false) }} No</label>
				</div>
			</div>
		</div>
	</div>

	<div class="btn-toolbar">
		<div class="btn-group">
			{{ Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}