<?php namespace Xtras\Presenters;

use HTML,
	Markdown;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter {

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

	public function siteBtn()
	{
		if ( ! empty($this->entity->url))
		{
			return HTML::link($this->entity->url, "Visit Author's Site", ['class' => 'btn btn-default']);
		}

		return false;
	}

}