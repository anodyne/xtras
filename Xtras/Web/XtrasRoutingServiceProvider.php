<?php namespace Xtras;

use Route;
use Illuminate\Support\ServiceProvider;

class XtrasRoutingServiceProvider extends ServiceProvider {

	public function register()
	{
		//
	}

	public function boot()
	{
		$this->defineRoutes();
	}

	protected function notes()
	{
		// When a user hits a route with a slug, we need to do a little
		// work to figure out if there's more than one items with that slug.
		// If there are, we need to show a list of those items instead of just
		// the item the user requested.
	}

	protected function defineRoutes()
	{
		/**
		 * Log In, Register. Password reset
		 */
		Route::get('login', [
			'as'	=> 'login',
			'uses'	=> 'Xtras\Controllers\MainController@login']);
		Route::post('login', 'Xtras\Controllers\MainController@doLogin');
		Route::get('logout', array(
			'as'	=> 'logout',
			'uses'	=> 'Xtras\Controllers\MainController@logout'));
		Route::get('register', array(
			'as'	=> 'register',
			'uses'	=> 'Xtras\Controllers\MainController@register'
		));
		Route::post('register', 'Xtras\Controllers\MainController@doRegistration');
		Route::controller('password', 'Xtras\Controllers\RemindersController');

		/**
		 * Xtras
		 */
		Route::group(array('before' => 'auth'), function()
		{
			Route::get('/', array(
				'as'	=> 'home',
				'uses'	=> 'Xtras\Controllers\MainController@index'
			));

			Route::get('item/{id}', array(
				'as'	=> 'item',
				'uses'	=> 'Xtras\Controllers\ItemController@show'
			));

			Route::get('skins', array(
				'as'	=> 'skins',
				'uses'	=> 'Xtras\Controllers\ItemController@index'
			));
			Route::get('ranks', array(
				'as'	=> 'ranks',
				'uses'	=> 'Xtras\Controllers\ItemController@index'
			));
			Route::get('mods', array(
				'as'	=> 'mods',
				'uses'	=> 'Xtras\Controllers\ItemController@index'
			));

			Route::get('account/edit/{slug}', array(
				'as'	=> 'account',
				'uses'	=> 'Xtras\Controllers\UserController@edit'
			));
			Route::get('account/xtras', [
				'as'	=> 'xtras',
				'uses'	=> 'Xtras\Controllers\UserController@xtras']);
			
			Route::resource('account', 'Xtras\Controllers\UserController');

			Route::get('search', [
				'as'	=> 'search',
				'uses'	=> 'Xtras\Controllers\SearchController@index']);
			Route::post('search', 'Xtras\Controllers\SearchController@doSearch');
			Route::get('results', [
				'as'	=> 'results',
				'uses'	=> 'Xtras\Controllers\SearchController@results']);
		});

		Route::get('profile/{name}', array(
			'as'	=> 'profile',
			'uses'	=> 'Xtras\Controllers\UserController@show'
		));

		Route::get('policies/{type?}', array(
			'as'	=> 'policies',
			'uses'	=> 'Xtras\Controllers\MainController@policies'));
	}

}