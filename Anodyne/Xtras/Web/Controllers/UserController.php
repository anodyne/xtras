<?php namespace Xtras\Controllers;

use View,
	Input,
	UserRepositoryInterface;

class UserController extends \BaseController {

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
			->withXtras($this->users->getItemsByType($this->currentUser));
	}

	public function notifications()
	{
		return View::make('pages.user.notifications')
			->withNotifications($this->users->getNotifications($this->currentUser));
	}

	public function addNotification()
	{
		// Get the values
		$user = Input::get('user');
		$item = Input::get('item');

		if ((int) $this->currentUser->id === (int) $user)
		{
			$this->users->addNotification($user, $item);
		}
	}

	public function removeNotification()
	{
		// Get the values
		$user = Input::get('user');
		$item = Input::get('item');

		if ((int) $this->currentUser->id === (int) $user)
		{
			$this->users->removeNotification($user, $item);
		}
	}

}