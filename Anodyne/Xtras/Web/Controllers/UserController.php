<?php namespace Xtras\Controllers;

use View, Input;

class UserController extends \BaseController {

	protected $users;

	public function __construct(\UserRepositoryInterface $users)
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

		return $this->errorNotFound("We couldn't find the user you're looking for.");
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
		if ($this->currentUser)
		{
			// Get the values
			$user = Input::get('user');
			$item = Input::get('item');

			if ((int) $this->currentUser->id === (int) $user)
			{
				$this->users->addNotification($user, $item);
			}
		}
	}

	public function removeNotification()
	{
		if ($this->currentUser)
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

	public function downloads()
	{
		return View::make('pages.user.downloads')
			->withOrders($this->users->getOrders($this->currentUser));
	}

}