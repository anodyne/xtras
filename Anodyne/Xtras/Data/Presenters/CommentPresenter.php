<?php namespace Xtras\Data\Presenters;

use Markdown;
use Laracasts\Presenter\Presenter;

class CommentPresenter extends Presenter {

	public function author()
	{
		return "<footer>{$this->entity->user->present()->name}</footer>";
	}

	public function content()
	{
		return Markdown::parse($this->entity->content);
	}

}