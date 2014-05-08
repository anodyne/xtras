@extends('layouts.master')

@section('title')
	Error!
@stop

@section('content')
	<h1 class="text-{{ $type }}">Error!</h1>

	{{ partial('alert', ['type' => $type, 'content' => $error]) }}
@stop