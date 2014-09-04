<?php namespace Xtras\Api\Transformers;

class ItemTransformer extends \League\Fractal\TransformerAbstract {

	public function transform(\ItemModel $item)
	{
		return [
			'name'				=> $item->name,
			'version'			=> $item->version,
			'description'		=> $item->desc,
			'support'			=> $item->support,
			'rating'			=> (float) round($item->rating, 2),
			'downloads'			=> (int) $item->present()->downloads,
			'link'				=> route('item.show', [$item->user->username, $item->slug]),
			'author'			=> $item->user->name,
			'author_profile'	=> route('account.profile', [$item->user->username]),
			'type'				=> $item->type->name,
			'product'			=> $item->product->name,
		];
	}

}