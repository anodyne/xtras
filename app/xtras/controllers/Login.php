<?php namespace Xtras\Controllers;

use Auth;
use View;
use Input;
use Redirect;
use UserNameTakenException;
use UserRepositoryInterface;

# TODO: error messages on failed log ins
# TODO: password reset

class Login extends Base {

	public function __construct(UserRepositoryInterface $user)
	{
		$this->user = $user;
	}

	public function getLogin()
	{
		return View::make('pages.login.login');
	}
	public function postLogin()
	{
		// Set the variables from the form
		$email = Input::get('email');
		$password = Input::get('password');

		// Attempt to log the user in
		if (Auth::attempt(array('email' => $email, 'password' => $password), true))
		{
			return Redirect::route('home');
		}

		return Redirect::route('login');
	}

	public function getRegister()
	{
		return View::make('pages.login.register');
	}
	public function postRegister()
	{
		try
		{
			// Create the new user
			$user = $this->user->create(Input::all());

			if ($user)
			{
				// Set the variables
				$email = Input::get('email');
				$password = Input::get('password');

				// Log the user in
				if (Auth::attempt(array('email' => $email, 'password' => $password), true))
				{
					return Redirect::route('home');
				}
			}

			return Redirect::route('login');
		}
		catch (UserNameTakenException $e)
		{
			return Redirect::route('register')->withInput();
		}
	}

}