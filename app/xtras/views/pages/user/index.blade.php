@extends('layouts.master')

@section('title')
	Users
@stop

@section('content')
	<h1>Users</h1>

	<div class="data-table data-table-bordered data-table-striped">
	@foreach ($users as $user)
		<div class="row">
			<div class="col-lg-10">
				<p>{{ $user->name }}</p>
			</div>
			<div class="col-lg-2">
				<div class="btn-toolbar pull-right">
					<div class="btn-group">
						<a href="{{ URL::route('user.edit', $user->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['user'] }}</a>
						<a href="{{ URL::route('user.edit', $user->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['edit'] }}</a>
					</div>
					<div class="btn-group">
						<a href="#" class="btn btn-sm btn-danger js-user-action icn-size-16" data-id="{{ $user->id }}" data-action="delete">{{ $_icons['remove'] }}</a>
					</div>
				</div>
			</div>
		</div>
	@endforeach
	</div>
@stop