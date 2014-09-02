<?php namespace Xtras\Events;

use ItemMailer as Mailer;

class ItemEventHandler {

	protected $mailer;

	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function onComment($comment)
	{
		// Send the email
		$this->mailer->addedComment($comment);
	}

	public function onCreate($item)
	{
		// If this is the first Xtra for the user, send them an email
		if ($item->user->items->count() == 1)
		{
			$this->mailer->firstXtra($item);
		}
	}

	public function onDelete($item)
	{
		//
	}

	public function onReportAbuse($item, $input)
	{
		// Send the email
		$this->mailer->reportAbuse($input);
	}

	public function onReportIssue($item, $input)
	{
		// Send the email
		$this->mailer->reportIssue($input);
	}

	public function onUpdate($item)
	{
		//
	}

	public function onFileDelete($file)
	{
		//
	}

	public function onFileUpload($item)
	{
		// If this is an update, grab the orders and notify anyone who's grabbed this before
	}

	public function onMessageCreate($message)
	{
		//
	}

	public function onMessageDelete($message)
	{
		//
	}

	public function onMessageUpdate($message)
	{
		//
	}

	public function onImageDelete($item)
	{
		//
	}

	public function onImageUpload($item)
	{
		//
	}

}