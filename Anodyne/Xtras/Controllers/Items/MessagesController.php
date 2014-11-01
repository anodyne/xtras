<?php namespace Xtras\Controllers\Items;

use Item,
	View,
	Event,
	Flash,
	Input,
	Redirect,
	BaseController,
	ItemMessageValidator,
	ItemRepositoryInterface;

class MessagesController extends BaseController {

	protected $items;
	protected $validator;

	public function __construct(ItemRepositoryInterface $items,
			ItemMessageValidator $validator)
	{
		parent::__construct();

		$this->items = $items;
		$this->validator = $validator;

		// Before filter to check if the user has permissions
		$this->beforeFilter('@checkEditPermissions');
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

			return $this->errorUnauthorized("You don't have access to manage messages for this Xtra.");
		}

		return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
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

			return $this->unauthorized("You don't have access to create messages for this Xtra.");
		}

		return $this->errorNotFound("We couldn't find the Xtra you're looking for.");
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
				$this->validator->validate(Input::all());

				// Store the message
				$message = $this->items->addMessage($item->id, Input::all());

				Event::fire('item.message.created', [$message]);

				Flash::success("Message was successfully created.");
			}
			else
			{
				Flash::error("You don't have access to create messages for this Xtra.");
			}
		}
		else
		{
			Flash::error("We couldn't find the Xtra you're looking for.");
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

			return $this->unauthorized("You don't have access to update messages for this Xtra.");
		}

		return $this->errorNotFound("We couldn't find the message you're looking for.");
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
				$this->validator->validate(Input::all());

				// Update the message
				$update = $this->items->updateMessage($message->id, Input::all());

				Event::fire('item.message.update', [$update]);

				Flash::success("Message was successfully updated.");
			}
			else
			{
				Flash::error("You don't have access to update messages for this Xtra.");
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

		if ($message)
		{
			$content = ($this->checkPermissions($message->item))
				? View::make('pages.item.messages-remove')->withMessage($message)
				: alert('danger', "You don't have access to update messages for this Xtra.");
		}
		else
		{
			$content = alert('danger', "We couldn't find the message you're looking for.");
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

				Event::fire('item.message.deleted', [$message]);

				Flash::success("Message was successfully removed.");

				return Redirect::route('item.messages.index', [
					$message->item->user->username,
					$message->item->slug
				]);
			}

			return $this->errorUnauthorized("You don't have access to remove messages for this Xtra.");
		}

		return $this->errorNotFound("We couldn't find the message you're looking for.");
	}

	public function checkPermissions(Item $item)
	{
		if ($item->isOwner($this->currentUser) or $this->currentUser->can('xtras.admin'))
		{
			return true;
		}

		return false;
	}

	public function checkEditPermissions()
	{
		if ( ! $this->currentUser->can('xtras.item.edit') and ! $this->currentUser->can('xtras.admin'))
		{
			return $this->errorUnauthorized("You don't have access to edit Xtras!");
		}
	}

}