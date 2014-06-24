<?php namespace Xtras\Controllers;

use Input,
	ItemRepositoryInterface;

class CommentController extends BaseController {

	protected $items;

	public function __construct(ItemRepositoryInterface $items)
	{
		$this->items = $items;
	}

	public function index($itemId)
	{
		return $this->items->getComments($itemId);
	}

	public function store($itemId)
	{
		return $this->items->addComment($itemId, Input::all());
	}

}