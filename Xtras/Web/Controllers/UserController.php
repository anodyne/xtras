<?php namespace Xtras\Controllers;

use Auth,
	View,
	Event,
	Redirect,
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
		// Validate

		// Update the user
		$user = $this->users->update(Input::all());

		// Fire the user update event
		Event::fire('user.updated', [$user]);

		return Redirect::route('account.edit', [$user->slug]);
	}

	public function destroy($id)
	{
		//
	}

	public function xtras()
	{
		// Get the user
		$user = Auth::user();

		return View::make('pages.user.xtras')
			->withSkins($user->items->filter(function($i){ return $i->type->name == 'Skin'; }))
			->withRanks($user->items->filter(function($i){ return $i->type->name == 'Rank Set'; }))
			->withMods($user->items->filter(function($i){ return $i->type->name == 'MOD'; }));
	}

}