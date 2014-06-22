@extends('layouts.master')

@section('title')
	{{ $item->present()->name }}
@stop

@section('content')
	<div class="row">
		<div class="col-lg-9">
			<h1>{{ $item->present()->name }} <small>{{ $item->present()->type }}</small></h1>

			<h4>by {{ $item->present()->author }}</h4>

			<div>{{ $item->present()->description }}</div>

			<div class="btn-toolbar">
				<div class="btn-group">
					<a href="#" class="btn btn-lg btn-primary"><span class="tab-icon tab-icon-up2 tab-icon-right">{{ $_icons['download'] }}</span>Download the Latest Version</a>
				</div>
			</div>

			<div class="btn-toolbar">
				<div class="btn-group">
					<a href="#" class="btn btn-default">Report an Issue</a>
				</div>
				<div class="btn-group">
					<a href="#" class="btn btn-default">Report Abuse to Anodyne</a>
				</div>
			</div>

			<div class="panel panel-warning">
				<div class="panel-heading">
					<h2 class="panel-title"><span class="tab-icon tab-icon-up2">{{ $_icons['warning'] }}</span>Report an Issue</h2>
				</div>
				<div class="panel-body">
					{{ Form::open() }}
						<div class="row">
							<div class="col-md-10 col-lg-10">
								<div class="form-group">
									<label>Message</label>
									{{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5]) }}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								{{ Form::button('Report Issue', ['type' => 'submit', 'class' => 'btn btn-default']) }}
							</div>
						</div>
					{{ Form::close() }}
				</div>
			</div>

			<div class="panel panel-danger">
				<div class="panel-heading">
					<h2 class="panel-title"><span class="tab-icon tab-icon-up2">{{ $_icons['warning'] }}</span>Report Abuse to Anodyne</h2>
				</div>
				<div class="panel-body">
					{{ Form::open() }}
						<div class="row">
							<div class="col-md-10 col-lg-10">
								<div class="form-group">
									<label>Message</label>
									{{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5]) }}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								{{ Form::button('Report Abuse', ['type' => 'submit', 'class' => 'btn btn-default']) }}
							</div>
						</div>
					{{ Form::close() }}
				</div>
			</div>

			<ul class="nav nav-tabs">
				<li class="active"><a href="#details" data-toggle="tab"><span class="tab-icon tab-icon-up3">{{ $_icons['info'] }}</span>Details</a></li>

				@if ($meta)
					@if ( ! empty($meta->installation))
						<li><a href="#install" data-toggle="tab"><span class="tab-icon tab-icon-up3">{{ $_icons['new'] }}</span>Installation</a></li>
					@endif

					@if ( ! empty($meta->history))
						<li><a href="#versions" data-toggle="tab"><span class="tab-icon tab-icon-up3">{{ $_icons['clock'] }}</span>Version History</a></li>
					@endif
				@endif

				<li class="visible-md visible-lg"><a href="#download" data-toggle="tab"><span class="tab-icon tab-icon-up3">{{ $_icons['download'] }}</span>Downloads</a></li>
				<li><a href="#comments" data-toggle="tab"><span class="tab-icon">{{ $_icons['comments'] }}</span> Comments {{ $item->present()->commentsCount }}</a></li>
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
				</div>

				@if ($meta)
					@if ( ! empty($meta->installation))
						<div id="install" class="tab-pane">
							{{ $meta->present()->installation }}
						</div>
					@endif

					@if ( ! empty($meta->history))
						<div id="versions" class="tab-pane">
							{{ $meta->present()->history }}
						</div>
					@endif
				@endif

				<div id="download" class="tab-pane">
					<div class="data-table data-table-striped data-table-bordered">
					@foreach ($files as $file)
						<div class="row">
							<div class="col-md-9 col-lg-9">
								<p class="lead"><strong>{{ $file->present()->version }}</strong></p>
								<p class="text-sm text-muted">{{ $file->present()->added }}</p>
							</div>
							<div class="col-md-3 col-lg-3">
								<div class="btn-toolbar pull-right">
									<div class="btn-group">
										<a href="{{ URL::route('item.download', [$item->id, $file->id]) }}" class="btn btn-default">{{ $_icons['download'] }}</a>
									</div>
								</div>
							</div>
						</div>
					@endforeach
					</div>
				</div>

				<div id="comments" class="tab-pane">
					<div class="btn-toolbar">
						<div class="btn-group">
							<a href="#" class="btn btn-default">Add a Comment</a>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-heading">
							<h2 class="panel-title"><span class="tab-icon tab-icon-up1">{{ $_icons['comment'] }}</span>Add a Comment</h2>
						</div>
						<div class="panel-body">
							{{ Form::open() }}
								<div class="row">
									<div class="col-md-10 col-lg-10">
										<div class="form-group">
											{{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5]) }}
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										{{ Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-default']) }}
									</div>
								</div>
							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<p><img src="http://placehold.it/250x250" class="img-rounded"></p>
			<p><img src="http://placehold.it/250x250" class="img-rounded"></p>
			<p><img src="http://placehold.it/250x250" class="img-rounded"></p>
		</div>
	</div>
@stop