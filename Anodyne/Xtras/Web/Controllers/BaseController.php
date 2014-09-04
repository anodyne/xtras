<?php namespace Xtras\Controllers;

use Log, Auth, View;

abstract class BaseController extends \Controller {

	protected $currentUser;
	protected $layout = 'layouts.master';
	protected $request;
	protected $fractal;

	public function __construct()
	{
		$this->currentUser	= (Auth::check()) ? Auth::getUser()->load('roles', 'roles.perms') : null;
		$this->request		= \Request::instance();
		$this->fractal		= new \League\Fractal\Manager;

		$this->fractal->setSerializer(new \League\Fractal\Serializer\DataArraySerializer);
	}

	protected function errorUnauthorized($message = false)
	{
		Log::error("{$this->currentUser->name} attempted to access {$this->request->fullUrl()}");

		if ($message)
		{
			return View::make('pages.error')->withError($message)->withType('danger');
		}
	}

	protected function errorNotFound($message = false)
	{
		Log::error("A user attempted to reach {$this->request->fullUrl()}");

		if ($message)
		{
			return View::make('pages.error')->withError($message)->withType('danger');
		}
	}

	protected function respondWithCollection($collection, $callback)
	{
		$resource = new \League\Fractal\Resource\Collection($collection, $callback);

		$rootScope = $this->fractal->createData($resource);

		return $this->respondWithArray($rootScope->toArray());
	}

	protected function respondWithArray(array $data, array $headers = [])
	{
		return \Response::json($data, 200, $headers);
	}

}