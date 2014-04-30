<?php

Route::get('test', function()
{
	$filesystem = App::make('xtras.filesystem');

	s($filesystem->put('foo.txt', "This is the content for my first file"));
	s($filesystem->has('foo.txt'));
});