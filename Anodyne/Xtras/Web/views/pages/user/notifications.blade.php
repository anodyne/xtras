@extends('layouts.master')

@section('title')
	My Notifications
@stop

@section('content')
	<h1>My Notifications</h1>

	@if ($notifications->count() > 0)
		<p>You have the option of being notified whenever an update is made to an Xtra. Below are all the Xtras you're receiving notifications for. If you'd like to remove a notification, simply click on the Remove button.</p>

		<div class="data-table data-table-bordered data-table-striped">
		@foreach ($notifications as $n)
			<div class="row">
				<div class="col-md-6">
					<p class="lead">{{ $n->item->present()->name }}</p>
				</div>
				<div class="col-md-3">
					<p class="text-muted">{{ $n->item->present()->updated }}</p>
				</div>
				<div class="col-md-3">
					<div class="btn-toolbar pull-right">
						<div class="btn-group">
							<a href="{{ route('item.show', [$n->item->user->username, $n->item->slug]) }}" class="btn btn-default">View</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-remove-notification" data-user="{{ $_currentUser->id }}" data-item="{{ $n->item->id }}">Remove</a>
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	@else
		{{ alert('warning', "You don't have any notifications.") }}
	@endif
@stop

@section('scripts')
	<script>
		$('.js-remove-notification').on('click', function(e)
		{
			e.preventDefault();

			$.ajax({
				url: "{{ route('account.notifications.remove') }}",
				type: "POST",
				data: {
					item: $(this).data('item'),
					user: $(this).data('user'),
					'_token': "{{ csrf_token() }}"
				},
				success: function(data)
				{
					window.location.reload();
				}
			});
		});
	</script>
@stop