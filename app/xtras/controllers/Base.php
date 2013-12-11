<?php namespace Xtras\Controllers;

use Log;
use Auth;
use View;
use Config;
use Request;
use stdClass;
use Controller;
use UserRepositoryInterface;

class Base extends Controller {

	protected $view;
	protected $data;
	protected $currentUser;
	protected $layout = 'layouts.master';
	protected $request;

	public function __construct()
	{
		$this->currentUser = Auth::user();
		$this->request = Request::instance();
		$this->data = new stdClass;
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout)->with('_icons', Config::get('icons'));
		}
	}

	protected function finalizeLayout()
	{
		if ( ! empty($this->view))
		{
			$this->layout->content = View::make("pages.{$this->view}")
				->with('_icons', Config::get('icons'))
				->with('_currentUser', $this->currentUser)
				->with((array) $this->data);
		}
	}

	protected function processResponse($router, $method, $response)
	{
		$this->finalizeLayout();

		return parent::processResponse($router, $method, $response);
	}

	protected function unauthorized()
	{
		Log::error("{$this->currentUser->name} attempted to access {$this->request->fullUrl()}");
	}

}