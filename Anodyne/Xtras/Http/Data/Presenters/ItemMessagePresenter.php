<?php namespace Xtras\Data\Presenters;

use Date, Markdown;
use Laracasts\Presenter\Presenter;

class ItemMessagePresenter extends Presenter {

	public function content()
	{
		return $this->entity->content;
	}

	public function expires()
	{
		return $this->entity->expires->format('d F Y');
	}

	public function expiresFormal()
	{
		if ( ! empty($this->entity->expires))
		{
			return $this->entity->expires->format('m/d/Y');
		}
	}

	public function expiresRelative()
	{
		// Get the dates
		$now = Date::now();
		$expires = $this->entity->expires;
		$diff = $now->diffInHours($expires);
		$output = '';

		if ($diff > 48)
		{
			$output = $this->expires();
		}

		if ($diff <= 48)
		{
			$output = "Tomorrow";
		}
		
		if ($diff <= 24)
		{
			$output = "Today";
		}

		return $output;
	}

	public function type()
	{
		return $this->entity->type;
	}

	public function typeAsLabel()
	{
		// Grab the type
		$type = $this->type();

		switch ($type)
		{
			case 'info':
				$content = "Info";
			break;
			
			case 'warning':
				$content = "Warning";
			break;

			case 'danger':
				$content = "Critical";
			break;
		}

		return label($type, $content);
	}

}