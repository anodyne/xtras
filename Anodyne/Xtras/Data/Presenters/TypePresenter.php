<?php namespace Xtras\Data\Presenters;

use Laracasts\Presenter\Presenter;

class TypePresenter extends Presenter {

	public function name()
	{
		return $this->entity->name;
	}

}