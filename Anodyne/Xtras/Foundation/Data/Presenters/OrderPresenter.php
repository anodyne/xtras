<?php namespace Xtras\Foundation\Data\Presenters;

use Markdown;
use Laracasts\Presenter\Presenter;

class OrderPresenter extends Presenter {

	public function downloaded()
	{
		return $this->entity->created_at->format('d F Y');
	}

}