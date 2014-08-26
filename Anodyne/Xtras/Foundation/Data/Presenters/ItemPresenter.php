<?php namespace Xtras\Foundation\Data\Presenters;

use Str,
	URL,
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

	public function author()
	{
		return HTML::link("profile/{$this->entity->user->username}", $this->entity->user->present()->name);
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

	public function downloads()
	{
		return $this->entity->orders->count();
	}

	public function downloadBtn()
	{
		// Get the icons
		$downloadIcon = \Config::get('icons.download');

		// Get the latest version
		$latest = $this->entity->getLatestVersion()->toArray();

		$link = \URL::route('item.download', [$this->entity->id, $latest['files']['id']]);
		$title = '<span class="tab-icon tab-icon-up1 tab-icon-right">'.$downloadIcon.'</span>';
		$title.= '<span class="visible-md">Download</span>';
		$title.= '<span class="visible-lg">Download Latest Version</span>';

		return '<a href="'.$link.'" class="btn btn-lg btn-block btn-primary">'.$title.'</a>';
	}

	public function inactiveMessage()
	{
		if ( ! $this->active())
		{
			return alert('danger', "This Xtra is not available at this time.");
		}
	}

	public function messages()
	{
		// Get right now...
		$now = \Date::now();

		// Start the output
		$output = "";

		if ($this->entity->messages->count() > 0)
		{
			foreach ($this->entity->messages as $message)
			{
				if ($message->expires === null or ($message->expires !== null and $now->lt($message->expires)))
				{
					$output .= alert($message->type, Markdown::parse($message->content));
				}
			}
		}

		return $output;
	}

	public function name()
	{
		return $this->entity->name;
	}

	public function product()
	{
		return $this->entity->product->present()->name;
	}

	public function productAsLabel()
	{
		return View::make('partials.label')
			->withClass('default')
			->withContent($this->product());
	}

	public function rating()
	{
		return sprintf('%01.1f', $this->entity->rating);
	}

	public function status()
	{
		return Markdown::parse($this->entity->status_message);
	}

	public function support()
	{
		if (Str::contains($this->entity->support, '@'))
		{
			return "mailto:{$this->entity->support}";
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

		return View::make('partials.label')
			->withClass($class)
			->withContent($this->entity->type->present()->name);
	}

	public function updated()
	{
		return $this->entity->updated_at->format('d F Y');
	}

}