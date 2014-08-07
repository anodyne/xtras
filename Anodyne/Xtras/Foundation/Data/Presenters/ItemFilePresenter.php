<?php namespace Xtras\Foundation\Data\Presenters;

use Markdown;
use Laracasts\Presenter\Presenter;

class ItemFilePresenter extends Presenter {

	public function added()
	{
		return $this->entity->created_at->format('d F Y');
	}

	public function filename()
	{
		return $this->entity->filename;
	}

	public function version()
	{
		return $this->entity->version;
	}

}