<?php namespace Xtras\Foundation\Data\Presenters;

use Markdown;
use Laracasts\Presenter\Presenter;

class ItemMetaPresenter extends Presenter {

	public function image1()
	{
		return $_ENV['FS_URL'].'/assets/'.$this->entity->image1;
	}

	public function image2()
	{
		return $_ENV['FS_URL'].'/assets/'.$this->entity->image2;
	}

	public function image3()
	{
		return $_ENV['FS_URL'].'/assets/'.$this->entity->image3;
	}

	public function installation()
	{
		return Markdown::parse($this->entity->installation);
	}

	public function history()
	{
		return Markdown::parse($this->entity->history);
	}

	public function thumbnail1()
	{
		return $_ENV['FS_URL'].'/assets/'.$this->entity->thumbnail1;
	}

	public function thumbnail2()
	{
		return $_ENV['FS_URL'].'/assets/'.$this->entity->thumbnail2;
	}

	public function thumbnail3()
	{
		return $_ENV['FS_URL'].'/assets/'.$this->entity->thumbnail3;
	}

}