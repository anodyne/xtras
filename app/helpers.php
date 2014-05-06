<?php

if ( ! function_exists('partial'))
{
	function partial($view, $data = false)
	{
		$view = View::make("partials.{$view}");

		if ($data)
		{
			$view->with((array) $data);
		}

		return $view;
	}
}