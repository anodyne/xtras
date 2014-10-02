<?php namespace Xtras\Events;

use Item,
	Comment,
	ItemMailer as Mailer;

class ItemEventHandler {

	protected $mailer;

	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function onComment(Comment $comment)
	{
		// Send the email
		$this->mailer->addedComment($comment);
	}

	public function onCreate(Item $item)
	{
		// If this is the first Xtra for the user, send them an email
		if ($item->user->items->count() == 1)
		{
			$this->mailer->firstXtra($item);
		}
	}

	public function onDelete(Item $item)
	{
		//
	}

	public function onReportAbuse(Item $item, $input)
	{
		// Send the email
		$this->mailer->reportAbuse($input);
	}

	public function onReportIssue(Item $item, $input)
	{
		// Send the email
		$this->mailer->reportIssue($input);
	}

	public function onUpdate(Item $item)
	{
		//
	}

	public function onFileDelete($file)
	{
		//
	}

	public function onFileUpload($item)
	{
		//
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

	public function notifyForNewVersion(Item $item)
	{
		// Send the email
		$this->mailer->notifyForNewVersion($item);
	}

}