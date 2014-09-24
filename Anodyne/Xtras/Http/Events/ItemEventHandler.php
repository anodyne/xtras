<?php namespace Xtras\Events;

use ItemMailer as Mailer;

class ItemEventHandler {

	protected $mailer;

	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function onComment($commentId)
	{
		// Send the email
		$this->mailer->addedComment($commentId);
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

	public function onUpdate($itemId)
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

	public function notifyForNewVersion($item)
	{
		// Send the email
		$this->mailer->notifyForNewVersion($item);
	}

}