<div class="data-table data-table-striped data-table-bordered">
@foreach ($items as $item)
	<div class="row {{ $item->product->present()->nameAsSlug }}">
		<div class="col-md-6">
			<p class="lead">{{ $item->present()->nameWithVersion }}</p>
			{{ $item->present()->disabledLabel }}
			{{ $item->present()->adminDisabledLabel }}
		</div>
		<div class="col-md-6">
			<div class="btn-toolbar pull-right">
				<div class="btn-group">
					<a href="{{ route('item.show', [$item->user->username, $item->slug]) }}" class="btn btn-default">View</a>
				</div>

				@if ($_currentUser->can('xtras.item.edit') or $_currentUser->can('xtras.admin'))
					<div class="btn-group">
						<a href="{{ route('item.edit', [$item->user->username, $item->slug]) }}" class="btn btn-default">Edit</a>
					</div>
					<div class="btn-group">
						<a href="{{ route('item.messages.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Messages</a>
						<a href="{{ route('item.files.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Files</a>
						<a href="{{ route('item.images.index', [$item->user->username, $item->slug]) }}" class="btn btn-default">Images</a>
					</div>
				@endif

				@if ($_currentUser->can('xtras.item.delete') or $_currentUser->can('xtras.admin'))
					<div class="btn-group">
						<a href="#" class="btn btn-danger js-remove-item" data-id="{{ $item->id }}">Remove</a>
					</div>
				@endif
			</div>
		</div>
	</div>
@endforeach
</div>