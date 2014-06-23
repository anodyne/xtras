<?php namespace Xtras\Presenters;

use URL,
	HTML,
	View,
	Markdown;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter {

	public function avatar(array $options)
	{
		// Figure out what the avatar file is
		$url = ($this->entity->avatar) ?: 'no-avatar.jpg';

		// Merge all the options to pass them to the partial
		$mergedOptions = $options + ['url' => URL::asset('images/avatars/'.$url)];

		return View::make('partials.avatar')->with($mergedOptions);
	}

	public function bio()
	{
		return Markdown::parse($this->entity->bio);
	}

	public function email()
	{
		return $this->entity->email;
	}

	public function itemsMods()
	{
		return $this->entity->items->filter(function($i)
		{
			return $i->type->name == 'MOD';
		})->sortBy(function($s){
			return $s->updated_at;
		});
	}

	public function itemsRanks()
	{
		return $this->entity->items->filter(function($i)
		{
			return $i->type->name == 'Rank Set';
		})->sortBy(function($s){
			return $s->updated_at;
		});
	}

	public function itemsSkins()
	{
		return $this->entity->items->filter(function($i)
		{
			return $i->type->name == 'Skin';
		})->sortBy(function($s){
			return $s->updated_at;
		});
	}

	public function name()
	{
		return $this->entity->name;
	}

	public function siteBtn()
	{
		if ( ! empty($this->entity->url))
		{
			return HTML::link($this->entity->url, "Author's Website", ['class' => 'btn btn-default']);
		}

		return false;
	}

}