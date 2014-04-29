<?php namespace Xtras\Presenters;

use Str,
	URL,
	HTML,
	View,
	Markdown;
use Laracasts\Presenter\Presenter;

class ItemPresenter extends Presenter {

	public function author()
	{
		return HTML::link("profile/{$this->entity->user->slug}", $this->entity->user->name);
	}

	public function created()
	{
		return $this->entity->created_at->format('d F Y');
	}

	public function description()
	{
		return Markdown::parse($this->entity->desc);
	}

	public function descriptionTruncated()
	{
		return '<p>'.Str::words(strip_tags($this->description()), 25).'</p>';
	}

	public function downloads()
	{
		return $this->entity->orders->count();
	}

	public function downloadBtn()
	{
		return HTML::link('', 'Download Latest Version', array('class' => 'btn btn-lg btn-primary'));
	}

	public function name()
	{
		return $this->entity->name;
	}

	public function product()
	{
		return $this->entity->product->name;
	}

	public function rating()
	{
		if ($this->entity->ratings->count() > 0)
		{
			$rating = 0;

			foreach ($this->entity->ratings as $r)
			{
				$rating += $r->rating;
			}

			return sprintf('%01.1f', round($rating / $this->entity->ratings->count(), 1));
		}

		return false;
	}

	public function status()
	{
		return Markdown::parse($this->entity->status_message);
	}

	public function type()
	{
		return $this->entity->type->name;
	}

	public function typeAsLabel()
	{
		switch ($this->entity->type->name)
		{
			case 'Skin':
				$class = 'info';
			break;

			case 'Rank Set':
				$class = 'success';
			break;

			case 'MOD':
				$class = 'danger';
			break;
		}

		return View::make('partials.label')
			->withClass($class)
			->withContent($this->entity->type->name);
	}

	public function updated()
	{
		return $this->entity->updated_at->format('d F Y');
	}

}