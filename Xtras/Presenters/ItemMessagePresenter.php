<?php namespace Xtras\Presenters;

use Markdown;
use Laracasts\Presenter\Presenter;

class ItemMessagePresenter extends Presenter {

	public function content()
	{
		return Markdown::parse($this->entity->content);
	}

}