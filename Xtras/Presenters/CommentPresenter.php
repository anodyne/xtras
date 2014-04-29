<?php namespace Xtras\Presenters;

use Markdown;
use Laracasts\Presenter\Presenter;

class CommentPresenter extends Presenter {

	public function content()
	{
		return Markdown::parse($this->entity->content);
	}

}