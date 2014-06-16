@extends('layouts.master')

@section('title')
	Site Policies
@stop

@section('content')
	<h1>Site Policies</h1>

	<dl>
		<dt><a href="{{ URL::route('policies', ['terms']) }}">Terms of Use</a></dt>
		<dd>No one likes reading all sorts of legal language. Instead, we want to make it clear, simple, and straightforward how we expect users of AnodyneXtras to behave. This page highlights the terms of use of the Service.</dd>

		<dt><a href="{{ URL::route('policies', ['privacy']) }}">Anodyne Privacy Policy</a></dt>
		<dd>We take the privacy of our users very seriously. This document outlines what data we have and how we handle it.</dd>

		<dt><a href="{{ URL::route('policies', ['browsers']) }}">Supported Browsers</a></dt>
		<dd>AnodyneXtras is designed to support the latest web browsers. This document outlines the various browsers we support.</dd>
	</dl>
@stop