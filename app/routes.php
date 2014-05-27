<?php

Route::get('test', function()
{
	$item = ItemModel::first();

	sd($item->meta->toArray());
});