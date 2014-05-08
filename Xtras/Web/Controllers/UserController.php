<?php namespace Xtras\Controllers;

use View,
	UserRepositoryContract;

class UserController extends BaseController {

	protected $users;

	public function __construct(UserRepositoryContract $users)
	{
		parent::__construct();

		$this->users = $users;
	}

	public function index()
	{
		//
	}

	public function create()
	{
		//
	}

	public function store()
	{
		//
	}

	public function show($name)
	{
		// Get the user from the slug
		$user = $this->users->findBySlug($name);

		if ($user)
		{
			return View::make('pages.user.show')->withUser($user);
		}

		return $this->errorNotFound('No profile exists with that name!');
	}

	public function edit($name)
	{
		// Get the user from the slug
		$user = $this->users->findBySlug($name);

		if ($user)
		{
			return View::make('pages.user.edit')->withUser($user);
		}
	}

	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}

}