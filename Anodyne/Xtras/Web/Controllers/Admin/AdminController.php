<?php namespace Xtras\Controllers\Admin;

use View,
	Input,
	Redirect;
use Xtras\Controllers\BaseController;

class AdminController extends BaseController {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if ($this->currentUser->can('xtras.admin'))
		{
			return View::make('pages.admin.index');
		}

		return $this->errorUnauthorized("You do not have permissions to administer AnodyneXtras");
	}

}