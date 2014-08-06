@extends('layouts.master')

@section('title')
	{{ $item->present()->name }}
@stop

@section('content')
	<div class="row" ng-controller="CommentsController">
		<div class="col-md-9 col-lg-9">
			<h1>{{ $item->present()->name }} <small>{{ $item->present()->type }}</small></h1>

			<h4>by {{ $item->present()->author }}</h4>

			<div>{{ $item->present()->messages }}</div>

			<div>{{ $item->present()->description }}</div>

			<div class="panel panel-warning hide" id="issuePanel">
				<div class="panel-heading">
					<button type="button" class="close">&times;</button>
					<h2 class="panel-title"><span class="tab-icon tab-icon-up2">{{ $_icons['warning'] }}</span>Report an Issue</h2>
				</div>
				<div class="panel-body">
					<p>Found an issue with this xtra? Let the developer know by sending them a message. Make sure to be specific about what's wrong, how to reproduce the issue, and any other information you think is pertinent (MODs you have installed, what skin you're using, what browser(s) you've run across the issue in, etc.).</p>

					{{ Form::open(['route' => ['item.reportIssue', $item->id]]) }}
						<div class="row">
							<div class="col-md-10 col-lg-10">
								<div class="form-group">
									<label>Message</label>
									{{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5]) }}
									<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
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

			<div class="panel panel-danger hide" id="abusePanel">
				<div class="panel-heading">
					<button type="button" class="close">&times;</button>
					<h2 class="panel-title"><span class="tab-icon tab-icon-up2">{{ $_icons['warning'] }}</span>Report Abuse to Anodyne</h2>
				</div>
				<div class="panel-body">
					<p>If you think this xtra is doing something malicious, has a virus attached to it, or is doing something that violates the Terms of Use, let Anodyne know and we'll look in to the issue further. Please include all relevant information about the abuse and any information you think is pertinent for Anodyne to know.</p>

					{{ Form::open(['route' => ['item.reportAbuse', $item->id]]) }}
						<div class="row">
							<div class="col-md-10 col-lg-10">
								<div class="form-group">
									<label>Message</label>
									{{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5]) }}
									<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
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
				<li class="active">
					<a href="#download" data-toggle="tab">
						<span class="visible-md tooltip-top" data-title="Downloads">{{ $_icons['download'] }}</span>
						<span class="visible-lg"><span class="tab-icon tab-icon-up3">{{ $_icons['download'] }}</span>Downloads</span>
					</a>
				</li>

				@if ($meta)
					@if ( ! empty($meta->installation))
						<li>
							<a href="#install" data-toggle="tab">
								<span class="visible-md tooltip-top" data-title="Installation">{{ $_icons['new'] }}</span>
								<span class="visible-lg"><span class="tab-icon tab-icon-up3">{{ $_icons['new'] }}</span>Installation</span>
							</a>
						</li>
					@endif

					@if ( ! empty($meta->history))
						<li>
							<a href="#versions" data-toggle="tab">
								<span class="visible-md tooltip-top" data-title="Versions">{{ $_icons['clock'] }}</span>
								<span class="visible-lg"><span class="tab-icon tab-icon-up3">{{ $_icons['clock'] }}</span>Version History</span>
							</a>
						</li>
					@endif

					@if ( ! empty($meta->image1) or ! empty($meta->image2) or ! empty($meta->image3))
						<li>
							<a href="#images" data-toggle="tab">
								<span class="visible-md tooltip-top" data-title="Images">{{ $_icons['images'] }}</span>
								<span class="visible-lg"><span class="tab-icon tab-icon-up3">{{ $_icons['images'] }}</span>Images</span>
							</a>
						</li>
					@endif
				@endif

				<li>
					<a href="#comments" data-toggle="tab">
						<span class="visible-md tooltip-top" data-title="Comments">{{ $_icons['comments'] }}</span>
						<span class="visible-lg"><span class="tab-icon">{{ $_icons['comments'] }}</span> Comments <span ng-if="countComments()">(<% countComments() %>)</span></span>
					</a>
				</li>
			</ul>

			<div class="tab-content">
				<div id="details" class="tab-pane">
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

					@if ( ! empty($meta->image1) or ! empty($meta->image2) or ! empty($meta->image3))
						<div id="images" class="tab-pane">
							{{ $meta->present()->history }}
						</div>
					@endif
				@endif

				<div id="download" class="active tab-pane">
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
							<a href="#" rel="comment" class="btn btn-default">Add a Comment</a>
						</div>
					</div>

					<div class="panel panel-default hide" id="commentPanel">
						<div class="panel-heading">
							<button type="button" class="close">&times;</button>
							<h2 class="panel-title"><span class="tab-icon tab-icon-up1">{{ $_icons['comment'] }}</span>Add a Comment</h2>
						</div>
						<div class="panel-body">
							<p>If you have an issue with this xtra, please use the Report Issue button at the top of the page. Comments should be used to ask questions or commend the author on their work.</p>
							
							<form ng-submit="addComment()">
								<div class="row">
									<div class="col-md-10 col-lg-10">
										<div class="form-group">
											{{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5, 'ng-model' => 'newCommentContent']) }}
											<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										{{ Form::button('Submit', ['type' => 'submit', 'id' => 'commentSubmit', 'class' => 'btn btn-default']) }}
									</div>
								</div>
							</form>
						</div>
					</div>

					<blockquote ng-repeat="comment in comments">
						<div ng-bind-html="comment.content"></div>
						<div ng-bind-html="comment.author"></div>
					</blockquote>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-lg-3">
			<p>{{ $item->present()->downloadBtn }}</p>

			<p><a href="#" rel="issue" class="btn btn-block btn-default">Report an Issue</a></p>

			<p><a href="#" rel="abuse" class="btn btn-block btn-default">
				<span class="visible-md">Report Abuse</span>
				<span class="visible-lg">Report Abuse to Anodyne</span>
			</a></p>

			<hr>

			<h2 class="text-right">Details</h2>

			<dl class="text-right">
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
	</div>
@stop

@section('scripts')
	<script>

		window.url = "{{ Request::root() }}";
		window.itemId = "{{ $item->id }}";
		window.userId = "{{ $_currentUser->id }}";

		$('.close').on('click', function()
		{
			$(this).closest('.panel').addClass('hide');
		});

		$('[rel="issue"]').on('click', function(e)
		{
			e.preventDefault();
			$('#issuePanel').removeClass('hide');
		});

		$('[rel="abuse"]').on('click', function(e)
		{
			e.preventDefault();
			$('#abusePanel').removeClass('hide');
		});

		$('[rel="comment"]').on('click', function(e)
		{
			e.preventDefault();
			$('#commentPanel').removeClass('hide');
		});

	</script>
@stop