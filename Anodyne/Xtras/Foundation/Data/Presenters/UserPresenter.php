<?php namespace Xtras\Foundation\Data\Presenters;

use URL,
	HTML,
	View,
	Gravatar,
	Markdown;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter {

	public function avatar(array $options)
	{
		// Figure out the fallback image
		$defaultImg = (\App::environment() == 'local') ? 'retro' : asset('images/avatars/no-avatar.jpg');

		// Build the URL for the avatar
		$url = ( ! empty($this->entity->avatar))
			? "{$_ENV['FS_URL']}/images/avatars/{$this->entity->avatar}"
			: Gravatar::image($this->entity->email, 500, $defaultImg, 'pg');

		// Merge all the options to pass them to the partial
		$mergedOptions = $options + ['url' => $url];

		return View::make('partials.image')->with($mergedOptions);
	}

	public function bio()
	{
		return Markdown::parse($this->entity->bio);
	}

	public function email()
	{
		return $this->entity->email;
	}

	public function facebook()
	{
		return $this->entity->facebook;
	}

	public function facebookBtn($classes = 'btn btn-default')
	{
		if ( ! empty($this->entity->facebook))
		{
			return HTML::link($this->entity->facebook, "Facebook", ['class' => $classes, 'target' => '_blank']);
		}

		return false;
	}

	public function google()
	{
		return $this->entity->google;
	}

	public function googleBtn($classes = 'btn btn-default')
	{
		if ( ! empty($this->entity->google))
		{
			return HTML::link($this->entity->google, "Google+", ['class' => $classes, 'target' => '_blank']);
		}

		return false;
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

	public function siteBtn($classes = 'btn btn-default')
	{
		if ( ! empty($this->entity->url))
		{
			return HTML::link($this->entity->url, "Author's Website", ['class' => $classes, 'target' => '_blank']);
		}

		return false;
	}

	public function twitter()
	{
		return $this->entity->twitter;
	}

	public function twitterBtn($classes = 'btn btn-default')
	{
		if ( ! empty($this->entity->twitter))
		{
			return HTML::link('http://twitter.com/'.str_replace('@', '', $this->entity->twitter), 'Twitter', ['class' => $classes, 'target' => '_blank']);
		}

		return false;
	}

}