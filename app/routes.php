<?php

Route::get('test', function()
{
	$item = ItemModel::first();

	s($item->orders->toArray());
});