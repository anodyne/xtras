<div class="xtra">
	{{ View::make('partials.avatar')->withType(false)->withUrl('http://www.hdwallpapers.in/walls/fantasy_space-wide.jpg')->withClass('item-preview') }}

	{{ $item->user->present()->avatar(['type' => 'link', 'link' => URL::route('profile', [$item->user->slug]), 'class' => 'avatar xtra-avatar img-circle']) }}

	<h4 class="xtra-heading">{{ $item->present()->name }}</h4>
	<div class="text-center">
		{{ $item->present()->typeAsLabel }}
		{{ $item->present()->productAsLabel }}
	</div>
	<div class="xtra-desc">
		<p><a href="{{ URL::route('item', [$item->id]) }}" class="btn btn-lg btn-block btn-default">More Info</a></p>
	</div>
</div>