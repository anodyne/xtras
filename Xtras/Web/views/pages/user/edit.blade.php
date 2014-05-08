@extends('layouts.master')

@section('title')
	Edit Account
@stop

@section('content')
	<h1>Edit Account <small>{{ $user->present()->name }}</small></h1>
@stop