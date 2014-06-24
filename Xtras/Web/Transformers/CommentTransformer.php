<?php namespace Xtras\Transformers;

use CommentModel;
use League\Fractal;

class CommentTransformer extends Fractal\TransformerAbstract {

	public function transform(CommentModel $comment)
	{
		return [
			'id'		=> (int) $comment->id,
			'author'	=> $comment->present()->author,
			'item'		=> (int) $comment->item->id,
			'content'	=> $comment->present()->content,
		];
	}
}