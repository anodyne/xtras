<?php namespace Xtras\Data\Presenters;

use Markdown;
use Laracasts\Presenter\Presenter;

class ItemMetadataPresenter extends Presenter {

	public function image1()
	{
		$path = $_ENV['FS_URL'].$this->entity->image1;

		if ( ! empty($this->entity->image1))
		{
			return '<a class="col-lg-4" href="'.$path.'"><p><img src="'.$this->thumbnail1().'"></p></a>';
		}

		return false;
	}

	public function image2()
	{
		$path = $_ENV['FS_URL'].$this->entity->image2;

		if ( ! empty($this->entity->image2))
		{
			return '<a class="col-lg-4" href="'.$path.'"><p><img src="'.$this->thumbnail2().'"></p></a>';
		}

		return false;
	}

	public function image3()
	{
		$path = $_ENV['FS_URL'].$this->entity->image3;

		if ( ! empty($this->entity->image3))
		{
			return '<a class="col-lg-4" href="'.$path.'"><p><img src="'.$this->thumbnail3().'"></p></a>';
		}

		return false;
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
		return $_ENV['FS_URL'].$this->entity->thumbnail1;
	}

	public function thumbnail2()
	{
		return $_ENV['FS_URL'].$this->entity->thumbnail2;
	}

	public function thumbnail3()
	{
		return $_ENV['FS_URL'].$this->entity->thumbnail3;
	}

}