<?php namespace Xtras\Events;

use ItemMailer as Mailer;

class ItemEventHandler {

	protected $mailer;

	public function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}

	public function onComment($data)
	{
		// Grab the data out of the array
		$item = $data['item'];
		$comment = $data['comment'];
		$input = $data['input'];

		// Send the email
		$this->mailer->addedComment($input);
	}

	public function onCreate($data)
	{
		// Grab the item out of the array
		$item = $data['item'];
	}

	public function onDelete($data)
	{
		// Grab the item out of the array
		$item = $data['item'];
	}

	public function onReportAbuse($data)
	{
		// Grab the data out of the array
		$item = $data['item'];
		$input = $data['input'];

		// Send the email
		$this->mailer->reportAbuse($input);
	}

	public function onReportIssue($data)
	{
		// Grab the data out of the array
		$item = $data['item'];
		$input = $data['input'];

		// Send the email
		$this->mailer->reportIssue($input);
	}

	public function onUpdate($data)
	{
		// Grab the item out of the array
		$item = $data['item'];
	}

	public function onUpload($data)
	{
		// Grab the item out of the array
		$item = $data['item'];

		// If this is an update, grab the orders and notify anyone who's grabbed this before
	}

}