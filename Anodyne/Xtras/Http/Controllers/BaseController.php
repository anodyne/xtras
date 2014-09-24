<?php namespace Xtras\Controllers;

use Log,
	Auth,
	View,
	Request,
	Response;
use League\Fractal\Manager as FractalManager,
	League\Fractal\Resource\Collection as FractalCollection,
	League\Fractal\Serializer\DataArraySerializer as FractalDataArraySerializer;

abstract class BaseController extends \Controller {

	protected $currentUser;
	protected $layout = 'layouts.master';
	protected $request;
	protected $fractal;

	public function __construct()
	{
		$this->currentUser	= (Auth::check()) ? Auth::getUser()->load('roles', 'roles.perms') : null;
		$this->request		= Request::instance();
		$this->fractal		= new FractalManager;

		$this->fractal->setSerializer(new FractalDataArraySerializer);
	}

	protected function errorUnauthorized($message = false)
	{
		// Log the error
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
		$resource = new FractalCollection($collection, $callback);

		$rootScope = $this->fractal->createData($resource);

		return $this->respondWithArray($rootScope->toArray());
	}

	protected function respondWithArray(array $data, array $headers = [])
	{
		return Response::json($data, 200, $headers);
	}

}