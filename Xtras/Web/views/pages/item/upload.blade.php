@extends('layouts.master')

@section('title')
	Upload Xtra
@stop

@section('content')
	<h1>Xtra Upload</h1>

	<p>In order to cover all scenarios, you should upload a primary preview image that is at least 800 pixels wide and 300 pixels tall. This ensures that the preview image will be sharp and clear in all use cases, including high resolution displays.</p>

		<div class="row">
			<div class="col-lg-3">
				{{ Form::button('Upload and Continue', ['type' => 'submit', 'class' => 'btn btn-lg btn-block btn-primary']) }}
			</div>
			<div class="col-lg-9">
				<button class="btn btn-lg btn-link" disabled="disabled">Next Step: Notify Users of Update <span class="icn-size-16">{{ $_icons['next'] }}</span></button>
			</div>
		</div>
@stop