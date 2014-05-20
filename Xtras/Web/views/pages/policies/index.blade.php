@extends('layouts.master')

@section('title')
	Site Policies
@stop

@section('content')
	<h1>Site Policies</h1>

	<dl>
		<dt><a href="{{ URL::route('policies', ['terms']) }}">AnodyneXtras Terms of Service</a></dt>
		<dd>Anodyne Productions provides AnodyneXtras to the community at no cost, but the terms in this document ouline how users are allowed to use the AnodyneXtras service.</dd>

		<dt><a href="{{ URL::route('policies', ['privacy']) }}">Anodyne Privacy Policy</a></dt>
		<dd>We take the privacy of our users very seriously. This document outlines what data we have and how we handle it.</dd>

		<dt><a href="{{ URL::route('policies', ['dmca']) }}">DMCA Takedown Policy</a></dt>
		<dd>In the event that you feel your property or content has been infringed on by Anodyne Productions or a third-party, the process outlined in this document will help you report and resolve the issue.</dd>

		<dt><a href="{{ URL::route('policies', ['browsers']) }}">Supported Browsers</a></dt>
		<dd>AnodyneXtras is designed to support the latest web browsers. This document outlines the various browsers we support.</dd>
	</dl>
@stop