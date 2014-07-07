@extends('layouts.master')

@section('title')
	Admin
@stop

@section('content')
	<h1>Admin</h1>

	<div class="row">
		<div class="col-md-9">
			
		</div>

		<div class="col-md-3">
			<div class="list-group">
				<a href="{{ route('admin.users.index') }}" class="list-group-item">
					<span class="badge">15</span>
					Users
				</a>
				<a href="{{ route('admin.items.index') }}" class="list-group-item">
					<span class="badge">1,023</span>
					Items
				</a>
				<a href="{{ route('admin.products.index') }}" class="list-group-item">Products</a>
				<a href="{{ route('admin.types.index') }}" class="list-group-item">Item Types</a>
			</div>
		</div>
	</div>
@stop