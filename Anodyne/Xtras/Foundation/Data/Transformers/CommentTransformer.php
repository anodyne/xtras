<?php namespace Xtras\Foundation\Data\Transformers;

class CommentTransformer extends \League\Fractal\TransformerAbstract {

	public function transform(\Comment $comment)
	{
		return [
			'id'		=> (int) $comment->id,
			'author'	=> $comment->present()->author,
			'item'		=> (int) $comment->item->id,
			'content'	=> $comment->present()->content,
		];
	}
}