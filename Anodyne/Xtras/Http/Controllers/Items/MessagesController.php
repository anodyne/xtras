<?php namespace Xtras\Controllers\Items;

use View,
	Event,
	Flash,
	Input,
	Redirect;

class MessagesController extends \BaseController {

	protected $items;

	public function __construct(\ItemRepositoryInterface $items)
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
			if ($item->user->id == $this->currentUser->id or $this->currentUser->can('xtras.admin'))
			{
				return View::make('pages.item.messages')
					->withItem($item)
					->withMessages($item->messages);
			}

			return $this->unauthorized("You do not have permission to manage messages for this Xtra!");
		}

		return $this->errorNotFound("Xtra not found.");
	}

	public function create($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			if ($item->user->id == $this->currentUser->id or $this->currentUser->can('xtras.admin'))
			{
				return View::make('pages.item.messages-create')
					->withItem($item)
					->withTypes(['info' => "Info", 'warning' => "Warning", 'danger' => "Critical"]);
			}

			return $this->unauthorized("You do not have permission to create messages for this Xtra!");
		}

		return $this->errorNotFound("Xtra not found.");
	}

	public function store($author, $slug)
	{
		// Get the item
		$item = $this->items->findByAuthorAndSlug($author, $slug);

		if ($item)
		{
			if ($item->user->id == $this->currentUser->id)
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
			Flash::error("No Xtra found with that name.");
		}

		return Redirect::route('messages.index', ['author' => $author, 'slug' => $slug]);
	}

	public function edit($id)
	{
		// Get the message
		$message = $this->items->getMessage($id);

		if ($message)
		{
			return View::make('pages.item.messages-edit')
				->withMessage($message)
				->withItem($message->item)
				->withTypes(['info' => "Info" , 'warning' => "Warning", 'danger' => "Critical"]);
		}

		return $this->errorNotFound("Message not found.");
	}

	public function update($id)
	{
		// Get the message
		$message = $this->items->getMessage($id);

		if ($message)
		{
			// Get the item
			$item = $message->item;

			if ($item->user->id == $this->currentUser->id)
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

			return Redirect::route('messages.index', [
				'author'	=> $item->user->username,
				'slug'		=> $item->slug
			]);
		}
		else
		{
			// Set the flash message
			Flash::error("No message found.");

			return Redirect::back();
		}
	}

	public function destroy($id)
	{
		//
	}

}