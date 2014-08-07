<?php namespace Xtras\Foundation\Data\Presenters;

use Markdown;
use Laracasts\Presenter\Presenter;

class ItemMessagePresenter extends Presenter {

	public function content()
	{
		return Markdown::parse($this->entity->content);
	}

}