<?php namespace Xtras\Api;

use Route;
use Illuminate\Support\ServiceProvider;

class XtrasApiServiceProvider extends ServiceProvider {

	public function register()
	{
		//
	}

	public function boot()
	{
		$this->routes();
	}

	protected function routes()
	{
		$options = [
			'version'	=> 'v1',
			'prefix'	=> 'api',
			'namespace'	=> 'Xtras\Api\Controllers',
		];

		Route::api($options, function()
		{
			Route::get('items', 'ItemController@index');
			Route::get('items/skins/{product?}', 'ItemController@skins');
			Route::get('items/ranks/{product?}', 'ItemController@ranks');
			Route::get('items/mods/{product?}', 'ItemController@mods');
		});
	}

}