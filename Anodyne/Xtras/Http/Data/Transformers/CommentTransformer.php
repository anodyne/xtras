<?php namespace Xtras\Data\Transformers;

use Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract {

	public function transform(Comment $comment)
	{
		return [
			'id'		=> (int) $comment->id,
			'author'	=> $comment->present()->author,
			'item'		=> (int) $comment->item->id,
			'content'	=> $comment->present()->content,
		];
	}
}