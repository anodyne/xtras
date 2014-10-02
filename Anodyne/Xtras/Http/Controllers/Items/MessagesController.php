<?php namespace Xtras\Controllers\Items;

use Item,
	View,
	Event,
	Flash,
	Input,
	Redirect,
	BaseController,
	ItemRepositoryInterface;

class MessagesController extends BaseController {

	protected $items;

	public function __construct(ItemRepositoryInterface $items)
	{
		parent::__construct();

		$this->items = $items;
	}

	public function index($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			if ($this->checkPermissions($item))
			{
				return View::make('pages.item.messages')
					->withItem($item)
					->withMessages($item->messages);
			}

			return $this->errorUnauthorized("You do not have permission to manage messages for this Xtra!");
		}

		return $this->errorNotFound("We could not find the Xtra you were looking for.");
	}

	public function create($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			if ($this->checkPermissions($item))
			{
				return View::make('pages.item.messages-create')
					->withItem($item)
					->withTypes(['info' => "Info", 'warning' => "Warning", 'danger' => "Critical"]);
			}

			return $this->unauthorized("You do not have permission to create messages for this Xtra!");
		}

		return $this->errorNotFound("We could not find the Xtra you were looking for.");
	}

	public function store($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			if ($this->checkPermissions($item))
			{
				// Validate the data

				// Store the message
				$message = $this->items->addMessage($item->id, Input::all());

				// Fire the event
				Event::fire('item.message.created', [$message]);

				// Set the flash message
				Flash::success("Message was successfully created.");
			}
			else
			{
				// Set the flash message
				Flash::error("You do not have permission to create messages for this Xtra!");
			}
		}
		else
		{
			// Set the flash message
			Flash::error("We could not find the Xtra you were looking for.");
		}

		return Redirect::route('item.messages.index', [$author, $slug]);
	}

	public function edit($messageId)
	{
		// Get the message
		$message = $this->items->getMessage($messageId);

		if ($message)
		{
			if ($this->checkPermissions($message->item))
			{
				return View::make('pages.item.messages-edit')
					->withMessage($message)
					->withItem($message->item)
					->withTypes(['info' => "Info" , 'warning' => "Warning", 'danger' => "Critical"]);
			}

			return $this->unauthorized("You do not have permission to update messages for this Xtra!");
		}

		return $this->errorNotFound("We could not find the message you were looking for.");
	}

	public function update($messageId)
	{
		// Get the message
		$message = $this->items->getMessage($messageId);

		if ($message)
		{
			// Get the item
			$item = $message->item;

			if ($this->checkPermissions($item))
			{
				// Validate the data

				// Update the message
				$update = $this->items->updateMessage($message->id, Input::all());

				// Fire the event
				Event::fire('item.message.update', [$update]);

				// Set the flash message
				Flash::success("Message was successfully updated.");
			}
			else
			{
				// Set the flash message
				Flash::error("You do not have permission to update messages for this Xtra!");
			}

			return Redirect::route('item.messages.index', [$item->user->username, $item->slug]);
		}
		else
		{
			// Set the flash message
			Flash::error("No message found.");

			return Redirect::back();
		}
	}

	public function remove($messageId)
	{
		// Get the message
		$message = $this->items->getMessage($messageId);

		$content = alert('danger', "You do not have permission to update messages for this Xtra!");

		if ($this->checkPermissions($message->item))
		{
			$content = View::make('pages.item.messages-remove')->withMessage($message);
		}

		return partial('modal_content', [
			'modalHeader'	=> "Remove Message",
			'modalBody'		=> $content,
			'modalFooter'	=> false,
		]);
	}

	public function destroy($messageId)
	{
		// Get the message
		$message = $this->items->getMessage($messageId);

		if ($message)
		{
			if ($this->checkPermissions($message->item))
			{
				// Remove the message
				$message = $this->items->deleteMessage($messageId);

				// Fire the event
				Event::fire('item.message.deleted', [$message]);

				// Set the flash message
				Flash::success("Message was successfully removed.");

				return Redirect::route('item.messages.index', [
					$message->item->user->username,
					$message->item->slug
				]);
			}

			return $this->errorUnauthorized("You do not have permissions to remove messages for this Xtra!");
		}

		return $this->errorNotFound("We could not find the message you were looking for.");
	}

	public function checkPermissions(Item $item)
	{
		if ($item->user->id == $this->currentUser->id or $this->currentUser->can('xtras.admin'))
		{
			return true;
		}

		return false;
	}

}