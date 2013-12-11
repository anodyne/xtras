<?php namespace Xtras\Controllers;

use Auth;
use View;
use Input;
use Redirect;
use UserRepositoryInterface;

class User extends Base {

	public function __construct(UserRepositoryInterface $user)
	{
		$this->user = $user;
	}

	public function getAccount()
	{
		return View::make('pages.user.account')
			->with('user', Auth::user());
	}

	public function getProfile($name)
	{
		return View::make('pages.user.profile')
			->with('user', $this->user->find($name));
	}

	public function getXtras()
	{
		return View::make('pages.user.xtras')
			->with('user', Auth::user());
	}

}