<?php namespace Xtras\Mailers;

use Mail;

abstract class BaseMailer {

	public function send($view, array $data)
	{
		return Mail::queue("emails.{$view}", $data, function($msg) use ($data)
		{
			// Set the TO
			if (array_key_exists('to', $data))
			{
				$msg->to($recipients['to']);
			}

			// If there's a reply to, add it
			if (array_key_exists('replyTo', $data))
			{
				$msg->replyTo($data['replyTo']);
			}

			// If there's a CC, add it
			if (array_key_exists('cc', $data))
			{
				$msg->cc($recipients['cc']);
			}

			// If there's a BCC, add it
			if (array_key_exists('bcc', $data))
			{
				$msg->bcc($recipients['bcc']);
			}

			// Set the subject
			$msg->subject("[AnodyneXtras] {$data['subject']}");

			// Set who it's coming from
			if (array_key_exists('from', $data))
			{
				$msg->from($data['from']);
			}
		});
	}

}