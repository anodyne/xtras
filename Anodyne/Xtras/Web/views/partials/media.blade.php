<div class="xtra">
	@if ( ! empty($item->meta->image1))
		<?php $preview = $item->meta->image1;?>
	@else
		<?php $preview = URL::asset('images/previews/space'.rand(1, 13).'.jpg');?>
	@endif
	
	{{ View::make('partials.image')->withType(false)->withUrl($preview)->withClass('item-preview') }}

	{{ $item->user->present()->avatar(['type' => 'link', 'link' => URL::route('account.profile', [$item->user->slug]), 'class' => 'avatar xtra-avatar img-circle']) }}

	<h4 class="xtra-heading">{{ $item->present()->name }}</h4>
	<div class="text-center">
		{{ $item->present()->typeAsLabel }}
		{{ $item->present()->productAsLabel }}
	</div>
	<div class="xtra-desc">
		<p><a href="{{ URL::route('item.show', [$item->user->slug, $item->slug]) }}" class="btn btn-lg btn-block btn-default">More Info</a></p>
	</div>
</div>