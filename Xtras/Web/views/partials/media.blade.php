<div class="media">
	<a class="pull-left" href="#"><img class="media-object img-circle" src="http://placehold.it/150x150"></a>
	<div class="media-body">
		<h3 class="media-heading">{{ $item->present()->name }}</h3>
		<p>
			{{ $item->present()->typeAsLabel }}
			{{ $item->present()->productAsLabel }}
		</p>

		<div class="text-sm">{{ $item->present()->descriptionTruncated }}</div>

		<div class="visible-xs visible-sm">
			<p><a href="{{ URL::route('item', array($item->slug)) }}" class="btn btn-lg btn-block btn-default">More Info</a></p>

			<p><a href="{{ URL::route('profile', array($item->user->slug)) }}" class="btn btn-lg btn-block btn-default">Author Profile</a></p>
		</div>

		<div class="visible-md visible-lg">
			<div class="btn-toolbar">
				<div class="btn-group">
					<a href="{{ URL::route('item', array($item->slug)) }}" class="btn btn-default">More Info</a>
				</div>
				<div class="btn-group">
					<a href="{{ URL::route('profile', array($item->user->slug)) }}" class="btn btn-default">Author Profile</a>
				</div>
			</div>
		</div>
	</div>
</div>