@extends('layouts.master')

@section('title')
	{{ $item->present()->name }}
@stop

@section('content')
	<div class="row">
		<div class="col-md-9">
			<h1>{{ $item->present()->name }} <small>{{ $item->present()->type }}</small></h1>

			<h4>by {{ $item->present()->author }}</h4>

			@if (Auth::check())
				@if ($_currentUser->can('xtras.admin') or $item->isOwner($_currentUser))
					<div class="btn-toolbar">
						<div class="btn-group">
							<a href="{{ route('item.edit', [$item->user->username, $item->slug]) }}" class="btn btn-default">Edit Xtra</a>
						</div>
						<div class="btn-group">
							<a href="{{ route('item.messages.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Edit Messages</a>
							<a href="{{ route('item.files.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Edit Files</a>
							<a href="{{ route('item.images.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Edit Images</a>
						</div>
					</div>
				@endif
			@endif

			{{ $item->present()->inactiveMessage }}

			<div>{{ $item->present()->messages }}</div>

			<div>{{ $item->present()->description }}</div>

			<p>{{ $item->present()->awards }}</p>

			@if (Auth::check())
				<div class="panel panel-warning hide" id="issuePanel">
					<div class="panel-heading">
						<button type="button" class="close">&times;</button>
						<h2 class="panel-title"><span class="tab-icon tab-icon-up2">{{ $_icons['warning'] }}</span>Report an Issue</h2>
					</div>
					<div class="panel-body">
						<p>Found an issue with this Xtra? Let the developer know by sending them a message. Make sure to be specific about what's wrong, how to reproduce the issue, and any other information you think is pertinent (MODs you have installed, what skin you're using, what browser(s) you've run across the issue in, etc.).</p>

						{{ Form::open(['route' => ['item.reportIssue', $item->user->username, $item->slug]]) }}
							<div class="row">
								<div class="col-md-10">
									<div class="form-group">
										<label class="control-label">Message</label>
										{{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5]) }}
										<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
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
						<p>If you think this Xtra is doing something malicious, has a virus attached to it, or is doing something that violates the Terms of Use, let Anodyne know and we'll look in to the issue further. Please include all relevant information about the abuse and any information you think is pertinent for Anodyne to know.</p>

						{{ Form::open(['route' => ['item.reportAbuse', $item->user->username, $item->slug]]) }}
							<div class="row">
								<div class="col-md-10">
									<div class="form-group">
										<label class="control-label">Message</label>
										{{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => 5]) }}
										<p class="help-block text-sm">{{ $_icons['markdown'] }} Parsed as Markdown</p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									{{ Form::button('Report Abuse', ['type' => 'submit', 'class' => 'btn btn-default']) }}
								</div>
							</div>
						{{ Form::close() }}
					</div>
				</div>
			@endif

			<ul class="nav nav-tabs">
				@if (Auth::check())
					<li>
						<a href="#download" data-toggle="tab">
							<span class="visible-md tooltip-top" data-title="Downloads">{{ $_icons['download'] }}</span>
							<span class="visible-lg"><span class="tab-icon tab-icon-up3">{{ $_icons['download'] }}</span>Downloads</span>
						</a>
					</li>
				@endif

				@if ($metadata)
					@if ( ! empty($metadata->installation))
						<li>
							<a href="#install" data-toggle="tab">
								<span class="visible-md tooltip-top" data-title="Installation">{{ $_icons['new'] }}</span>
								<span class="visible-lg"><span class="tab-icon tab-icon-up3">{{ $_icons['new'] }}</span>Installation</span>
							</a>
						</li>
					@endif

					@if ( ! empty($metadata->history))
						<li>
							<a href="#versions" data-toggle="tab">
								<span class="visible-md tooltip-top" data-title="Versions">{{ $_icons['clock'] }}</span>
								<span class="visible-lg"><span class="tab-icon tab-icon-up3">{{ $_icons['clock'] }}</span>Version History</span>
							</a>
						</li>
					@endif

					@if ( ! empty($metadata->image1) or ! empty($metadata->image2) or ! empty($metadata->image3))
						<li>
							<a href="#images" data-toggle="tab">
								<span class="visible-md tooltip-top" data-title="Images">{{ $_icons['images'] }}</span>
								<span class="visible-lg"><span class="tab-icon tab-icon-up3">{{ $_icons['images'] }}</span>Images</span>
							</a>
						</li>
					@endif
				@endif

				@if (Auth::check())
					<li>
						<a href="#comments" data-toggle="tab">
							<span class="visible-md tooltip-top" data-title="Comments">{{ $_icons['comments'] }}</span>
							<span class="visible-lg"><span class="tab-icon">{{ $_icons['comments'] }}</span> Comments {{ $commentCount }}</span>
						</a>
					</li>
				@endif
			</ul>

			<div class="tab-content">
				@if ($metadata)
					@if ( ! empty($metadata->installation))
						<div id="install" class="tab-pane">
							{{ $metadata->present()->installation }}
						</div>
					@endif

					@if ( ! empty($metadata->history))
						<div id="versions" class="tab-pane">
							{{ $metadata->present()->history }}
						</div>
					@endif

					@if ( ! empty($metadata->image1) or ! empty($metadata->image2) or ! empty($metadata->image3))
						<div id="images" class="tab-pane">
							<div class="row gallery">
								{{ $metadata->present()->image1 }}
								{{ $metadata->present()->image2 }}
								{{ $metadata->present()->image3 }}
							</div>
						</div>
					@endif
				@endif

				@if (Auth::check())
					<div id="download" class="active tab-pane">
						<div class="data-table data-table-striped data-table-bordered">
						@foreach ($files as $file)
							<div class="row">
								<div class="col-md-9">
									<p class="lead"><strong>{{ $file->present()->version }}</strong></p>
									<p class="text-sm text-muted">{{ $file->present()->added }}</p>
								</div>
								<div class="col-md-3">
									@if ($item->present()->active)
										<div class="btn-toolbar pull-right">
											<div class="btn-group">
												<a href="{{ URL::route('item.download', [$item->user->username, $item->slug, $file->id]) }}" class="btn btn-default">Download</a>
											</div>
										</div>
									@endif
								</div>
							</div>
						@endforeach
						</div>
					</div>

					<div id="comments" class="tab-pane">
						<div class="btn-toolbar">
							<div class="btn-group">
								<a href="{{ route('item.comment.create', [$item->id]) }}" class="btn btn-default">Add a Comment</a>
							</div>
						</div>

						@foreach ($comments as $comment)
							@if ($comment->user->id == $item->user->id)
								<blockquote class="author">
							@else
								<blockquote>
							@endif
								{{ $comment->present()->content }}
								{{ $comment->present()->author }}
							</blockquote>
						@endforeach
					</div>
				@endif
			</div>
		</div>

		<div class="col-md-3">
			@if (Auth::check())
				@if ($item->present()->active and $item->getLatestVersion()['files'] !== null)
					<p>{{ $item->present()->downloadBtn }}</p>
				@endif

				<p>
					@if ( ! empty($item->support) and ! $item->supportIsEmail())
						<a href="{{ $item->support }}" target="_blank" class="btn btn-block btn-default">Get Help</a>
					@else
						<a href="#" rel="issue" class="btn btn-block btn-default">Report an Issue</a>
					@endif
				</p>

				<p><a href="#" rel="abuse" class="btn btn-block btn-default">
					<span class="visible-md">Report Abuse</span>
					<span class="visible-lg">Report Abuse to Anodyne</span>
				</a></p>

				<hr class="partial-split">

				@if ( ! $item->isOwner($_currentUser))
					{{ partial('rating', ['id' => $item->id, 'r' => $userRating]) }}

					<hr class="partial-split">

					{{ Form::open() }}
						<div class="pull-right">
							<label class="checkbox-inline">{{ Form::checkbox('notify', 1, $notify, ['class' => 'js-notification']) }} Notify me of releases</label>
						</div>
					{{ Form::close() }}
					<div class="clearfix"></div>

					<hr>
				@endif
			@else
				{{ alert('warning', "In order to download Xtras, you must have an AnodyneID. You can ".link_to_route('login', 'log in')." or <a href='http://anodyne-productions.com/register'>register</a> your AnodyneID.") }}
			@endif

			<h2 class="text-right">Details</h2>

			<dl class="text-right">
				<dt>Author</dt>
				<dd>{{ $item->present()->author }}</dd>

				<dt>Downloads</dt>
				<dd>{{ $item->present()->downloads }}</dd>

				@if ($item->present()->rating !== false)
					<dt>Rating</dt>
					<dd>{{ $item->present()->ratingAsLabel }}</dd>
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

@section('styles')
	{{ HTML::style('css/bootstrap-gallery.min.css') }}
@stop

@section('scripts')
	{{ HTML::script('js/bootstrap-gallery.js') }}
	{{ partial('js/item-rate') }}
	<script>
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

		$('.js-notification').on('change', function(e)
		{
			var send = {
				item: "{{ $item->id }}",
				user: "{{ (Auth::check()) ? $_currentUser->id : false }}",
				'_token': "{{ csrf_token() }}"
			};

			if ($(this).is(':checked'))
			{
				$.ajax({
					url: "{{ route('account.notifications.add') }}",
					type: "POST",
					data: send
				});
			}
			else
			{
				$.ajax({
					url: "{{ route('account.notifications.remove') }}",
					type: "POST",
					data: send
				});
			}
		});

		$(document).ready(function()
		{
			// Show the first tab
			$('.nav-tabs a:first').tab('show');

			// Activate the gallery
			$('.gallery').bootstrapGallery({
				iconset: "fontawesome"
			});
		});
	</script>
@stop