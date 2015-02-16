<?php namespace Xtras\Controllers;

use Redirect,
	BaseController;

class MainController extends BaseController {

	public function nova1()
	{
		return Redirect::to('search/advanced-results?p[]=1&q=');
	}

	public function nova2()
	{
		return Redirect::to('search/advanced-results?p[]=2&q=');
	}

	public function search()
	{
		return Redirect::route('search.advanced');
	}

	public function home()
	{
		return Redirect::route('home');
	}

	public function ranks()
	{
		return Redirect::to('search/advanced-results?t[]=2&q=');
	}

	public function skins()
	{
		return Redirect::to('search/advanced-results?t[]=1&q=');
	}

	public function mods()
	{
		return Redirect::to('search/advanced-results?t[]=3&q=');
	}

}