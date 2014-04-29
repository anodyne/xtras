<?php namespace Xtras\Controllers;

use Auth,
	View,
	Input,
	Session,
	Redirect,
	Validator,
	UserRepositoryContract;

class LoginController extends BaseController {

	protected $user;
	
	public function __construct(UserRepositoryContract $user)
	{
		parent::__construct();

		$this->user = $user;
	}

	public function index()
	{
		return View::make('pages.login');
	}

	public function doLogin()
	{
		$validator = Validator::make(Input::all(), array(
			'email'		=> 'required',
			'password'	=> 'required',
		));

		if ( ! $validator->passes())
		{
			Session::flash('loginMessage', "Your information couldn't be validated. Please correct the issues and try again.");

			return Redirect::route('login')->withInput()->withErrors($validator->errors());
		}

		$email = trim(Input::get('email'));
		$password = trim(Input::get('password'));

		if (Auth::attempt(array('email' => $email, 'password' => $password), true))
		{
			if (Session::has('url.intended'))
			{
				return Redirect::intended('home');
			}
			else
			{
				return Redirect::route('home');
			}
		}

		Session::flash('loginMessage', "Either your email address or password were incorrect. Please try again.");

		return Redirect::route('login')->withInput();
	}

	public function logout()
	{
		// Log the user out
		Auth::logout();

		return Redirect::route('home');
	}

	public function register()
	{
		return View::make('pages.register');
	}

	public function doRegistration()
	{
		# code...
	}

}