<?php namespace Xtras\Providers;

use Route;
use ItemType;
use Illuminate\Support\ServiceProvider;

class XtrasProvider extends ServiceProvider {

	public function register()
	{
		//
	}

	public function boot()
	{
		$this->defineRoutes();
		$this->setupBindings();
	}

	protected function defineRoutes()
	{
		/**
		 * Log In and Register
		 */
		Route::get('login', array(
			'as'	=> 'login',
			'uses'	=> 'Xtras\Controllers\Login@getLogin'
		));
		Route::post('login', 'Xtras\Controllers\Login@postLogin');
		Route::get('register', array(
			'as'	=> 'register',
			'uses'	=> 'Xtras\Controllers\Login@getRegister'
		));
		Route::post('register', 'Xtras\Controllers\Login@postRegister');

		/**
		 * Xtras
		 */
		Route::group(array('before' => 'auth'), function()
		{
			Route::get('/', array(
				'as'	=> 'home',
				'uses'	=> 'Xtras\Controllers\Home@getIndex'
			));

			Route::get('skin/{name}', array(
				'as'	=> 'skin',
				'uses'	=> 'Xtras\Controllers\Items@getItem'
			));
			Route::get('skins', array(
				'as'	=> 'skins',
				'uses'	=> 'Xtras\Controllers\Items@getItems'
			));

			Route::get('rank/{name}', array(
				'as'	=> 'rank',
				'uses'	=> 'Xtras\Controllers\Items@getItem'
			));
			Route::get('ranks', array(
				'as'	=> 'ranks',
				'uses'	=> 'Xtras\Controllers\Items@getItems'
			));

			Route::get('mod/{name}', array(
				'as'	=> 'mod',
				'uses'	=> 'Xtras\Controllers\Items@getItem'
			));
			Route::get('mods', array(
				'as'	=> 'mods',
				'uses'	=> 'Xtras\Controllers\Items@getItems'
			));

			Route::get('account', array(
				'as'	=> 'account',
				'uses'	=> 'Xtras\Controllers\User@getAccount'
			));
			Route::get('profile/{name}', array(
				'as'	=> 'profile',
				'uses'	=> 'Xtras\Controllers\User@getProfile'
			));
		});

		Route::resource('user', 'Xtras\Controllers\UserController');

		Route::get('profile/{id}', array(
			'as' => 'user.profile',
			'uses' => 'Xtras\Controllers\UserController@show'
		));
	}

	protected function setupBindings()
	{
		// Get the class aliases
		$a = $this->app['config']->get('app.aliases');

		$this->app->bind($a['XtraRepositoryInterface'], $a['XtraRepository']);
		$this->app->bind($a['UserRepositoryInterface'], $a['UserRepository']);
	}

}