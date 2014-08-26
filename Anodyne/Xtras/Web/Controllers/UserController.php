<?php namespace Xtras\Controllers;

use Auth,
	View,
	Event,
	Redirect,
	UserRepositoryInterface;

class UserController extends BaseController {

	protected $users;

	public function __construct(UserRepositoryInterface $users)
	{
		parent::__construct();

		$this->users = $users;
	}

	public function show($name)
	{
		// Get the user from their username
		$user = $this->users->findByUsername($name);

		if ($user)
		{
			return View::make('pages.user.show')->withUser($user);
		}

		return $this->errorNotFound('No profile exists with that name!');
	}

	public function xtras()
	{
		return View::make('pages.user.xtras')
			->withSkins($this->users->findItemsByType($this->currentUser, 'Skin', true))
			->withMods($this->users->findItemsByType($this->currentUser, 'MOD', true))
			->withRanks($this->users->findItemsByType($this->currentUser, 'Rank Set', true));
	}

}