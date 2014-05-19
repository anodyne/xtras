<?php

Route::get('test', function()
{
	echo Markdown::parse('# Hello Parsedown');
});