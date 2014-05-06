<?php namespace Xtras\Controllers;

use Auth,
	View,
	Event,
	Input,
	Session,
	Redirect,
	Validator,
	ItemRepositoryContract,
	UserRepositoryContract;

class MainController extends BaseController {

	protected $items;
	protected $users;

	public function __construct(ItemRepositoryContract $items, UserRepositoryContract $users)
	{
		parent::__construct();

		$this->items = $items;
		$this->users = $users;
	}

	public function index()
	{
		if (Auth::check())
		{
			return View::make('pages.main')
				->withNew($this->items->getRecentlyAdded(5))
				->withUpdated($this->items->getRecentlyUpdated(5));
		}
		else
		{
			return View::make('pages.login');
		}
	}

	public function doLogin()
	{
		$validator = Validator::make(Input::all(), array(
			'email'		=> 'required',
			'password'	=> 'required',
		));

		if ( ! $validator->passes())
		{
			Session::flash('flashStatus', 'danger');
			Session::flash('flashMessage', "Your information couldn't be validated. Please correct the issues and try again.");

			return Redirect::back()->withInput()->withErrors($validator->errors());
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

		Session::flash('flashStatus', 'danger');
		Session::flash('flashMessage', "Either your email address or password were incorrect. Please try again.");

		return Redirect::back()->withInput();
	}

	public function logout()
	{
		Auth::logout();
		
		return Redirect::route('home');
	}

	public function register()
	{
		// Generate a random number
		$random = mt_rand(1, 99);

		// Put the number into the session
		Session::flash('confirmNumber', $random);

		return View::make('pages.register')->with('confirmNumber', $random);
	}
	public function doRegistration()
	{
		// Setup the validator
		$validator = Validator::make(Input::all(), array(
			'name'				=> 'required',
			'email'				=> 'required|email|unique:users,email',
			'password'			=> 'required',
			'password_confirm'	=> 'required|same:password',
			'confirm'			=> 'required'
		), array(
			'email.unique'		=> "The email address you entered is already registered. You can <a href='".\URL::route('home')."'>log in</a>, or, if you've forgotten your password, you can reset it from the <a href='".\URL::to('password/remind')."'>Reset Password</a> page.",
		));

		// Validator failed
		if ( ! $validator->passes())
		{
			// Flash the session
			Session::flash('registerMessage', "Your information couldn't be validated. Please correct the issues and try again.");

			return Redirect::route('register')
				->withInput()
				->withErrors($validator->errors());
		}

		// Make sure the confirmation number matches
		if (Input::get('confirm') != Session::get('confirmNumber'))
		{
			return Redirect::route('register')
				->with('message', "Registration failed due to incorrect anti-spam confirmation number.")
				->with('messageStatus', 'danger');
		}

		// Create the user
		$user = $this->users->create(Input::all());

		if ($user)
		{
			// Log the user in
			Auth::login($user, true);

			// Fire the registration event
			Event::fire('user.registered', array($user, Input::all()));

			return Redirect::route('home')
				->with('message', "Welcome to the Brian Jacobs Golf scheduler! An email has been sent with the log in information you entered during registration. If you don't see the email, make sure to check your spam folder. From the scheduler, you can book lessons with a Brian Jacobs Golf instructor and enroll in any of our programs. Get started today by booking a lesson or enrolling in a program!")
				->with('messageStatus', 'success');
		}
		else
		{
			return Redirect::route('register')
				->withInput()
				->with('registerMessage', "There was an error creating your account. Please try again!");
		}
	}

}