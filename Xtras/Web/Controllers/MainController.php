<?php namespace Xtras\Controllers;

use Auth,
	View,
	Event,
	Input,
	Session,
	Redirect,
	Validator,
	ItemRepositoryInterface,
	UserRepositoryInterface;

class MainController extends BaseController {

	protected $items;
	protected $users;

	public function __construct(ItemRepositoryInterface $items, UserRepositoryInterface $users)
	{
		parent::__construct();

		$this->items = $items;
		$this->users = $users;
	}

	public function index()
	{
		return View::make('pages.main')
			->withNew($this->items->getRecentlyAdded(9))
			->withUpdated($this->items->getRecentlyUpdated(9));
	}

	public function login()
	{
		return View::make('pages.login');
	}

	public function doLogin()
	{
		// Validate
		$validator = Validator::make(Input::all(), [
			'email'		=> 'required',
			'password'	=> 'required',
		], [
			'email.required' => "Email address is required.",
			'password.required' => "Passwords cannot be blank.",
		]);

		if ( ! $validator->passes())
		{
			return Redirect::route('login')
				->withInput()
				->withErrors($validator->errors())
				->with('flashStatus', 'danger')
				->with('flashMessage', "Please enter your email address and password and try again.");
		}

		// Grab the values and trim them
		$email = trim(Input::get('email'));
		$password = trim(Input::get('password'));

		if (Auth::attempt(['email' => $email, 'password' => $password], true))
		{
			if (Session::has('url.intended'))
			{
				return Redirect::intended('home');
			}
			
			return Redirect::route('home');
		}

		return Redirect::route('login')
			->withInput()
			->with('flashStatus', 'danger')
			->with('flashMessage', "Either your email address or password were incorrect. Please try again.");
	}

	public function logout()
	{
		Auth::logout();
		
		return Redirect::route('home');
	}

	public function register()
	{
		// Generate a random number
		$random = mt_rand(1, 999);

		// Put the number into the session
		Session::flash('confirmNumber', $random);

		return View::make('pages.register')->with('confirmNumber', $random);
	}

	public function doRegistration()
	{
		// Setup the validator
		$validator = Validator::make(Input::all(), [
			'name'				=> 'required',
			'email'				=> 'required|email|unique:users,email',
			'password'			=> 'required',
			'password_confirm'	=> 'required|same:password',
			'confirm'			=> 'required'
		], [
			'email.unique'		=> "The email address you entered is already registered. You can <a href='".\URL::route('home')."'>log in</a>, or, if you've forgotten your password, you can reset it from the <a href='".\URL::to('password/remind')."'>Reset Password</a> page.",
		]);

		// Validator failed
		if ( ! $validator->passes())
		{
			// Flash the session
			Session::flash('flashStatus', 'danger');
			Session::flash('flashMessage', "Your information couldn't be validated. Please correct the issues and try again.");

			return Redirect::route('register')
				->withInput()
				->withErrors($validator->errors());
		}

		// Make sure the confirmation number matches
		if (Input::get('confirm') != Session::get('confirmNumber'))
		{
			return Redirect::route('register')
				->with('flashMessage', "Registration failed due to incorrect anti-spam confirmation number.")
				->with('flashStatus', 'danger');
		}

		// Create the user
		$user = $this->users->create(Input::all(), false);

		if ($user)
		{
			// Log the user in
			Auth::login($user, true);

			// Fire the registration event
			Event::fire('user.registered', [$user, Input::all()]);

			return Redirect::route('home')
				->with('flashMessage', "Welcome to AnodyneXtras!")
				->with('flashStatus', 'success');
		}
		else
		{
			return Redirect::route('register')
				->withInput()
				->with('flashMessage', "There was an error creating your account. Please try again!")
				->with('flashStatus', 'danger');
		}
	}

	public function policies($type = false)
	{
		switch ($type)
		{
			case 'browsers':
				$view = 'pages.policies.browsers';
			break;

			case 'dmca':
				$view = 'pages.policies.dmca';
			break;

			case 'privacy':
				$view = 'pages.policies.privacy';
			break;

			case 'terms':
				$view = 'pages.policies.terms';
			break;

			default:
				$view = 'pages.policies.index';
			break;
		}

		return View::make($view);
	}

	public function faq()
	{
		return View::make('pages.faq');
	}

}