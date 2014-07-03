<?php namespace Xtras\Controllers\Admin;

use View,
	Input,
	Redirect;
use Xtras\Controllers\BaseController;

class AdminController extends BaseController {

	public function index()
	{
		return View::make('pages.admin.index');
	}

}