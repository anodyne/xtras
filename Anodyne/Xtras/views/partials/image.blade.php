@if ($type == 'link')
	<a href="{{ $link }}" class="{{ $class }}" style="background-image:url({{ $url }});background-position:top center;"></a>
@else
	<div class="{{ $class }}" style="background-image:url({{ $url }});background-position:top center;"></div>
@endif