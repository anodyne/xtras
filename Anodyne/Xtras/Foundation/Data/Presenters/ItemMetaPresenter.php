<?php namespace Xtras\Foundation\Data\Presenters;

use Markdown;
use Laracasts\Presenter\Presenter;

class ItemMetaPresenter extends Presenter {

	public function installation()
	{
		return Markdown::parse($this->entity->installation);
	}

	public function history()
	{
		return Markdown::parse($this->entity->history);
	}

}