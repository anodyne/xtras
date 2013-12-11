<?php

if ( ! function_exists('partial'))
{
	function partial($view, $data)
	{
		return View::make("partials.{$view}")->with((array) $data);
	}
}