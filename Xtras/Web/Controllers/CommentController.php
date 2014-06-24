<?php namespace Xtras\Controllers;

use Input,
	CommentTransformer,
	ItemRepositoryInterface;

class CommentController extends BaseController {

	protected $items;

	public function __construct(ItemRepositoryInterface $items)
	{
		parent::__construct();
		
		$this->items = $items;
	}

	public function index($itemId)
	{
		return $this->respondWithCollection($this->items->getComments($itemId), new CommentTransformer);
	}

	public function store($itemId)
	{
		return $this->items->addComment($itemId, Input::all());
	}

}