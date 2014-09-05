<?php namespace Xtras\Controllers\Items;

class CommentsController extends \BaseController {

	protected $items;

	public function __construct(\ItemRepositoryInterface $items)
	{
		parent::__construct();
		
		$this->items = $items;
	}

	public function index($itemId)
	{
		// Get the comments
		return $this->respondWithCollection($this->items->getComments($itemId), new \CommentTransformer);
	}

	public function store($itemId)
	{
		// Store the comment
		$comment = $this->items->addComment($itemId, \Input::all());

		// Fire the event
		\Event::fire('item.comment', [$comment->id]);

		return $comment;
	}

}