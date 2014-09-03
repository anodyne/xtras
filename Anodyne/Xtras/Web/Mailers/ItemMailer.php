<?php namespace Xtras\Mailers;

use HTML,
	Config,
	ItemRepositoryInterface,
	UserRepositoryInterface;

class ItemMailer extends BaseMailer {

	protected $items;
	protected $users;

	public function __construct(ItemRepositoryInterface $items,
			UserRepositoryInterface $users)
	{
		$this->items = $items;
		$this->users = $users;
	}

	public function addedComment($commentId)
	{
		// Get the comment
		$comment = $this->items->findComment($commentId);

		if ($comment)
		{
			// Get the user it's coming from
			$user = $comment->user;

			// Get the item we're dealing with
			$item = $comment->item;

			$emailData = [
				'subject' => "Comment Added - ".$item->present()->name,
				'content' => $comment->present()->content,
				'from' => Config::get('xtras.abuseEmail'),
				'replyTo' => $user->email,
				'to' => $item->user->email,
				'name' => HTML::link(route('item.show', [$item->user->username, $item->slug]), $item->present()->name),
				'type' => $item->present()->type,
				'userName' => $user->present()->name,
			];

			return $this->send('comment', $emailData);
		}

		return false;
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
				'subject' => "Abuse Reported - ".$item->present()->name,
				'content' => $data['content'],
				'from' => $user->present()->email,
				'replyTo' => $user->present()->email,
				'to' => Config::get('xtras.abuseEmail'),
				'name' => HTML::link(route('item.show', [$item->user->username, $item->slug]), $item->present()->name),
				'type' => $item->present()->type,
				'userName' => $user->present()->name,
				'userEmail' => $user->present()->email,
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

			// Figure out where the email should go
			$to = ( ! empty($item->support) and filter_var($item->support, FILTER_VALIDATE_EMAIL))
				? $item->support
				: $item->user->email;

			$emailData = [
				'subject' => "Issue Reported - ".$item->present()->name,
				'content' => $data['content'],
				'from' => $user->present()->email,
				'replyTo' => $user->present()->email,
				'to' => $to,
				'name' => HTML::link(route('item.show', [$item->user->username, $item->slug]), $item->present()->name),
				'type' => $item->present()->type,
				'userName' => $user->present()->name,
				'userEmail' => $user->present()->email,
			];

			return $this->send('issue', $emailData);
		}

		return false;
	}

	public function firstXtra($item)
	{
		$emailData = [
			'subject' => "Congratulations!",
			'from' => Config::get('xtras.abuseEmail'),
			'replyTo' => Config::get('xtras.abuseEmail'),
			'to' => $item->user->email,
		];

		return $this->send('first-xtra', $emailData);
	}

}