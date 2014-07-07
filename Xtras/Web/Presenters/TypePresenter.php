<?php namespace Xtras\Presenters;

use Str,
	View,
	Config,
	Markdown;
use Laracasts\Presenter\Presenter;

class TypePresenter extends Presenter {

	public function name()
	{
		return $this->entity->name;
	}

}