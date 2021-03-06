<?php namespace Xtras\Data\Presenters;

use Str,
	URL,
	Date,
	HTML,
	View,
	Config,
	Markdown;
use Laracasts\Presenter\Presenter;

class ItemPresenter extends Presenter {

	public function active()
	{
		return (bool) $this->entity->status;
	}

	public function adminActive()
	{
		return (bool) $this->entity->admin_status;
	}

	public function adminDisabledLabel()
	{
		if ( ! $this->adminActive())
		{
			return '<p>'.label('danger', "This Xtra has been disabled by Anodyne Productions").'</p>';
		}

		return false;
	}

	public function author()
	{
		return HTML::link("profile/{$this->entity->user->username}", $this->entity->user->present()->name);
	}

	public function awards()
	{
		$output = "";

		if ((bool) $this->entity->award_creativity)
		{
			$output.= '<span class="award award-creativity"></span>';
		}

		if ((bool) $this->entity->award_presentation)
		{
			$output.= '<span class="award award-presentation"></span>';
		}

		if ((bool) $this->entity->award_technical)
		{
			$output.= '<span class="award award-technical"></span>';
		}

		return $output;
	}

	public function awardIcons()
	{
		$output = "";

		if ((bool) $this->entity->award_creativity)
		{
			$output.= '<span class="text-award-creativity">'.Config::get('icons.award').'</span> ';
		}

		if ((bool) $this->entity->award_presentation)
		{
			$output.= '<span class="text-award-presentation">'.Config::get('icons.award').'</span> ';
		}

		if ((bool) $this->entity->award_technical)
		{
			$output.= '<span class="text-award-technical">'.Config::get('icons.award').'</span> ';
		}

		return $output;
	}

	public function commentsCount()
	{
		return "({$this->entity->comments->count()})";
	}

	public function created()
	{
		return $this->entity->created_at->format('d F Y');
	}

	public function description()
	{
		return Markdown::parse($this->entity->desc);
	}

	public function descriptionTruncated()
	{
		return '<p>'.Str::words(strip_tags($this->description()), 25).'</p>';
	}

	public function disabledLabel()
	{
		if ( ! $this->active())
		{
			return '<p>'.label('warning', "This Xtra has been disabled").'</p>';
		}

		return false;
	}

	public function downloads()
	{
		$entity = $this->entity;
		
		return $this->entity->orders->filter(function($o) use ($entity)
		{
			return $o->user_id != $entity->user_id;
		})->count();
	}

	public function downloadBtn()
	{
		// Get the icons
		$downloadIcon = Config::get('icons.download');

		// Get the latest version
		$latest = $this->entity->getLatestVersion()->toArray();

		$downloadOptions = [
			$this->entity->user->username,
			$this->entity->slug,
			$latest['files']['id']
		];

		$link = route('item.download', $downloadOptions);
		$title = '<span class="tab-icon tab-icon-up2 tab-icon-right">'.$downloadIcon.'</span>';
		$title.= '<span class="visible-md">Download</span>';
		$title.= '<span class="visible-lg">Download Latest Version</span>';

		return '<a href="'.$link.'" class="btn btn-lg btn-block btn-primary">'.$title.'</a>';
	}

	public function inactiveMessage()
	{
		if ( ! $this->active() or ! $this->adminActive())
		{
			return alert('danger', "This Xtra is not available at this time.");
		}
	}

	public function messages()
	{
		// Get right now...
		$now = Date::now();

		// Start the output
		$output = "";

		if ($this->entity->messages->count() > 0)
		{
			foreach ($this->entity->messages as $message)
			{
				if ($message->expires === null or ($message->expires !== null and $now->lt($message->expires)))
				{
					$output .= alert($message->type, $message->present()->content);
				}
			}
		}

		return $output;
	}

	public function name()
	{
		return $this->entity->name;
	}

	public function nameWithVersion()
	{
		$output = $this->name();

		if ( ! empty($this->entity->version))
		{
			$output.= " {$this->version()}";
		}

		return $output;
	}

	public function product()
	{
		return $this->entity->product->present()->name;
	}

	public function productAsLabel()
	{
		return label('default', $this->product());
	}

	public function rating()
	{
		return sprintf('%01.1f', $this->entity->rating);
	}

	public function ratingAsLabel()
	{
		$type = 'danger';
		$text = Config::get('icons.star').' '.$this->rating();

		if ($this->rating() >= 4)
		{
			$type = 'info';
		}
		elseif ($this->rating() >= 2)
		{
			$type = 'warning';
		}
		elseif ($this->rating() == 0.0)
		{
			$type = 'default';
			$text = 'No ratings';
		}

		return label($type, $text);
	}

	public function status()
	{
		return Markdown::parse($this->entity->status_message);
	}

	public function support()
	{
		if (filter_var($this->entity->support, FILTER_VALIDATE_EMAIL))
		{
			return 'email';
		}

		return $this->entity->support;
	}

	public function type()
	{
		return $this->entity->type->present()->name;
	}

	public function typeAsLabel()
	{
		switch ($this->entity->type->name)
		{
			case 'Skin':
				$class = 'info';
			break;

			case 'Rank Set':
				$class = 'success';
			break;

			case 'MOD':
				$class = 'danger';
			break;
		}

		return label($class, $this->entity->type->present()->name);
	}

	public function version()
	{
		return $this->entity->version;
	}

	public function updated()
	{
		return $this->entity->updated_at->format('d F Y');
	}

}