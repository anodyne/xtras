<?php namespace Xtras\Mailers;

use Config;

class ItemMailer extends BaseMailer {

	public function addedComment($data)
	{
		# code...
	}

	public function reportAbuse($data)
	{
		// Get the item
		$item = $this->items->find($data['item_id']);

		if ($item)
		{
			// Get the user it's coming from
			$user = $this->users->find($data['user_id']);

			$emailData = [
				'subject'	=> "Abuse Reported - ".$item->present()->name,
				'content'	=> $data['content'],
				'from'		=> $user->present()->email,
				'to'		=> Config::get('xtras.abuseEmail'),
				'xtraName'	=> $item->present()->name,
				'xtraType'	=> $item->present()->type,
				'xtraUrl'	=> \URL::route('item.show', [$item->user->slug, $item->slug]),
				'userName'	=> $user->present()->name,
				'userEmail'	=> $user->present()->email,
			];

			return $this->send('abuse', $emailData);
		}

		return false;
	}

	public function reportIssue($data)
	{
		// Get the item
		$item = $this->items->find($data['item_id']);

		if ($item)
		{
			// Get the user it's coming from
			$user = $this->users->find($data['user_id']);

			$emailData = [
				'subject'	=> "Issue Reported - ".$item->present()->name,
				'content'	=> $data['content'],
				'from'		=> $user->present()->email,
				'to'		=> $item->user->present()->email,
				'xtraName'	=> $item->present()->name,
				'xtraType'	=> $item->present()->type,
				'xtraUrl'	=> \URL::route('item.show', [$item->user->slug, $item->slug]),
				'userName'	=> $user->present()->name,
				'userEmail'	=> $user->present()->email,
			];

			return $this->send('issue', $emailData);
		}

		return false;
	}

}