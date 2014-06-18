@extends('layouts.master')

@section('title')
	{{ $item->present()->name }}
@stop

@section('content')
	<h1>{{ $item->present()->name }} <small>{{ $item->present()->type }}</small></h1>

	<h4>by {{ $item->present()->author }}</h4>

	<div>{{ $item->present()->description }}</div>

	<div class="visible-md visible-lg">
		{{ partial('btn-toolbar', ['data' => [0 => [['link' => '#', 'text' => '<span class="tab-icon tab-icon-up2 tab-icon-right">'.$_icons['download'].'</span>Download the Latest Version', 'class' => 'btn btn-lg btn-primary']]]]) }}
	</div>

	<div class="row">
		<div class="col-lg-9">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#details" data-toggle="tab"><span class="tab-icon tab-icon-up3">{{ $_icons['info'] }}</span>Details</a></li>

				@if ($meta and ! empty($meta->installation))
					<li><a href="#install" data-toggle="tab"><span class="tab-icon tab-icon-up3">{{ $_icons['new'] }}</span>Installation</a></li>
				@endif

				<li><a href="#versions" data-toggle="tab"><span class="tab-icon tab-icon-up3">{{ $_icons['clock'] }}</span>Version History</a></li>
				<li class="visible-md visible-lg"><a href="#download" data-toggle="tab"><span class="tab-icon tab-icon-up3">{{ $_icons['download'] }}</span>Downloads</a></li>
				<li><a href="#comments" data-toggle="tab"><span class="tab-icon">{{ $_icons['comment'] }}</span> Comments {{ $item->present()->commentsCount }}</a></li>
			</ul>

			<div class="tab-content">
				<div id="details" class="active tab-pane">
					<h2>Details</h2>

					<dl>
						<dt>Author</dt>
						<dd>{{ $item->present()->author }}</dd>

						<dt>Downloads</dt>
						<dd>{{ $item->present()->downloads }}</dd>

						@if ($item->present()->rating !== false)
							<dt>Rating</dt>
							<dd>{{ $item->present()->rating }}</dd>
						@endif

						<dt>Added</dt>
						<dd>{{ $item->present()->created }}</dd>

						@if ($item->present()->created != $item->present()->updated)
							<dt>Last Updated</dt>
							<dd>{{ $item->present()->updated }}</dd>
						@endif
					</dl>

					{{ partial('btn-toolbar', ['data' => [0 => [['link' => '#', 'text' => 'Report an Issue', 'class' => 'btn btn-default']], 1 => [['link' => '#', 'text' => 'Report Abuse to Anodyne', 'class' => 'btn btn-default']]]]) }}
				</div>

				@if ($meta and ! empty($meta->installation))
					<div id="install" class="tab-pane">
						<h2>Installation</h2>

						{{ $meta->present()->installation }}
					</div>
				@endif

				<div id="versions" class="tab-pane">
					<h2>Version History</h2>
				</div>

				<div id="download" class="tab-pane">
					<h2>Downloads</h2>
				</div>

				<div id="comments" class="tab-pane">
					<h2>Comments</h2>

					{{ partial('btn-toolbar', ['data' => [0 => [['link' => '#', 'text' => 'Add a Comment', 'class' => 'btn btn-default']]]]) }}
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<p><img src="http://placehold.it/250x250"></p>
			<p><img src="http://placehold.it/250x250"></p>
			<p><img src="http://placehold.it/250x250"></p>
		</div>
	</div>
@stop