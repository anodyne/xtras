{{ Form::model($type, ['route' => ['admin.types.update', $type->id], 'method' => 'put']) }}
	<div class="row">
		<div class="col-md-9">
			<div class="form-group">
				<label class="control-label">Name</label>
				{{ Form::text('name', null, ['class' => 'form-control']) }}
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

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				{{ Form::button('Update', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary']) }}
			</div>
		</div>
	</div>
{{ Form::close() }}