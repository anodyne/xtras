<?php namespace Xtras\Foundation\Data\Presenters;

use Str, Markdown;
use Laracasts\Presenter\Presenter;

class ProductPresenter extends Presenter {

	public function desc()
	{
		return Markdown::parse($this->entity->desc);
	}

	public function name()
	{
		return $this->entity->name;
	}

	public function nameAsSlug()
	{
		return Str::slug(Str::lower($this->entity->name));
	}

}