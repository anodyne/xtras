<?php namespace Xtras\Controllers\Items;

use Event,
	Flash,
	Input,
	Redirect,
	BaseController,
	ItemRepositoryInterface;

class CommentsController extends BaseController {

	protected $items;

	public function __construct(ItemRepositoryInterface $items)
	{
		parent::__construct();
		
		$this->items = $items;
	}

	public function store($itemId)
	{
		// Get the item
		$item = $this->items->find($itemId);

		// Build the input
		$input = ['user_id' => (int) $this->currentUser->id] + Input::all();

		// Store the comment
		$comment = $this->items->addComment($item, $input);

		// Fire the event
		Event::fire('item.comment', [$comment]);

		Flash::success("Comment successfully added.");

		return Redirect::route('item.show', [$item->user->username, $item->slug]);
	}

}