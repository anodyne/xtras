<?php namespace Xtras\Controllers;

use App,
	View,
	Input,
	BaseController,
	ItemRepositoryInterface,
	UserRepositoryInterface;

class UserController extends BaseController {

	protected $items;
	protected $users;

	public function __construct(UserRepositoryInterface $users,
			ItemRepositoryInterface $items)
	{
		parent::__construct();

		$this->items = $items;
		$this->users = $users;
	}

	public function show($username)
	{
		$user = $this->users->findByUsername($username);

		if ($user)
		{
			return View::make('pages.user.show')->withUser($user);
		}

		return $this->errorNotFound("We couldn't find the user you're looking for.");
	}

	public function xtras()
	{
		return View::make('pages.user.xtras')
			->withXtras($this->users->getItemsByType($this->currentUser))
			->withUsage($this->items->reportUserSizes($this->currentUser));
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

	public function downloads()
	{
		return View::make('pages.user.downloads')
			->withOrders($this->users->getOrders($this->currentUser));
	}

}