<div class="media">
	<a class="pull-left" href="#"><img class="media-object img-circle" src="http://placehold.it/150x150"></a>
	<div class="media-body">
		<h3 class="media-heading">{{ $item->present()->name }}</h3>
		<p>
			{{ $item->present()->typeAsLabel }}
			{{ $item->present()->productAsLabel }}
		</p>

		<div class="text-sm">{{ $item->present()->descriptionTruncated }}</div>

		{{ partial('btn-toolbar', ['data' => [0 => [['link' => URL::route('item', array($item->id)), 'text' => 'More Info', 'class' => 'btn btn-default']], 1 => [['link' => URL::route('profile', array($item->user->slug)), 'text' => 'Author Profile', 'class' => 'btn btn-default']]]]) }}
	</div>
</div>