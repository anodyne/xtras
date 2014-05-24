<?php namespace Xtras\Presenters;

use URL,
	HTML,
	View,
	Markdown;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter {

	public function avatar(array $options)
	{
		$mergedOptions = $options + ['url' => URL::asset('images/ap-avatar.jpg')];

		return View::make('partials.avatar')->with($mergedOptions);
	}

	public function bio()
	{
		return Markdown::parse($this->entity->bio);
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
			return HTML::link($this->entity->url, "Visit Author's Site", ['class' => 'btn btn-default']);
		}

		return false;
	}

}