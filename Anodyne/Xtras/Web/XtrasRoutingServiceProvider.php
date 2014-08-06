<?php namespace Xtras;

use Route;
use Illuminate\Support\ServiceProvider;

class XtrasRoutingServiceProvider extends ServiceProvider {

	public function register() {}

	public function boot()
	{
		$this->routeProtections();

		$this->sessionsRoutes();
		$this->pagesRoutes();
		$this->itemRoutes();
		$this->searchRoutes();
		$this->accountRoutes();
		$this->miscRoutes();
		$this->adminRoutes();
	}

	protected function routeProtections()
	{
		// Make sure CSRF protection is in place
		Route::when('*', 'csrf', ['post', 'put', 'patch']);
	}

	protected function sessionsRoutes()
	{
		Route::get('login', [
			'as'	=> 'login',
			'uses'	=> 'Xtras\Controllers\MainController@login']);
		Route::post('login', [
			'as'	=> 'login.do',
			'uses'	=> 'Xtras\Controllers\MainController@doLogin']);
		Route::get('logout', [
			'as'	=> 'logout',
			'uses'	=> 'Xtras\Controllers\MainController@logout']);
		
		Route::get('register', [
			'as'	=> 'register',
			'uses'	=> 'Xtras\Controllers\MainController@register']);
		Route::post('register', [
			'as'	=> 'register.do',
			'uses'	=> 'Xtras\Controllers\MainController@doRegistration']);

		Route::group(['prefix' => 'password', 'namespace' => 'Xtras\Controllers'], function()
		{
			Route::get('remind', [
				'as'	=> 'password.remind',
				'uses'	=> 'RemindersController@remind']);
			Route::post('remind', [
				'as'	=> 'password.remind.do',
				'uses'	=> 'RemindersController@doRemind']);
			Route::get('reset/{token}', [
				'as'	=> 'password.reset',
				'uses'	=> 'RemindersController@reset']);
			Route::post('reset', [
				'as'	=> 'password.reset.do',
				'uses'	=> 'RemindersController@doReset']);
		});
	}

	protected function pagesRoutes()
	{
		Route::group(['namespace' => 'Xtras\Controllers'], function()
		{
			Route::get('/', [
				'before'	=> 'auth',
				'as'		=> 'home',
				'uses'		=> 'MainController@index']);

			Route::get('skins', [
				'before'	=> 'auth',
				'as'		=> 'skins',
				'uses'		=> 'ItemController@skins']);
			Route::get('ranks', [
				'before'	=> 'auth',
				'as'		=> 'ranks',
				'uses'		=> 'ItemController@ranks']);
			Route::get('mods', [
				'before'	=> 'auth',
				'as'		=> 'mods',
				'uses'		=> 'ItemController@mods']);

			Route::get('policies/{type?}', [
				'as'		=> 'policies',
				'uses'		=> 'MainController@policies']);
			Route::get('faq', [
				'as'		=> 'faq',
				'uses'		=> 'MainController@faq']);
		});
	}

	protected function searchRoutes()
	{
		$groupOptions = [
			'before'	=> 'auth',
			'prefix'	=> 'search',
			'namespace' => 'Xtras\Controllers'
		];

		Route::group($groupOptions, function()
		{
			Route::post('/', [
				'as'	=> 'search.do',
				'uses'	=> 'SearchController@doSearch']);
			Route::get('results', [
				'as'	=> 'search.results',
				'uses'	=> 'SearchController@results']);
			Route::get('advanced', [
				'as'	=> 'search.advanced',
				'uses'	=> 'SearchController@advanced']);
			Route::post('advanced', [
				'as'	=> 'search.doAdvanced',
				'uses'	=> 'SearchController@doAdvancedSearch']);
		});
	}

	protected function itemRoutes()
	{
		$groupOptions = [
			'before'	=> 'auth',
			'prefix'	=> 'item',
			'namespace' => 'Xtras\Controllers'
		];

		Route::group($groupOptions, function()
		{
			Route::get('create', [
				'as'	=> 'item.create',
				'uses'	=> 'ItemController@create']);
			Route::post('/', [
				'as'	=> 'item.store',
				'uses'	=> 'ItemController@store']);

			Route::get('{author}/{slug}/edit', [
				'as'	=> 'item.edit',
				'uses'	=> 'ItemController@edit']);
			Route::put('{id}', [
				'as'	=> 'item.update',
				'uses'	=> 'ItemController@update']);

			Route::delete('{id}', [
				'as'	=> 'item.destroy',
				'uses'	=> 'ItemController@destroy']);

			Route::get('{id}/upload', [
				'as'	=> 'item.upload',
				'uses'	=> 'ItemController@upload']);
			Route::post('{id}/upload-zip', [
				'as'	=> 'item.upload.doZip',
				'uses'	=> 'ItemController@doZipUpload']);
			Route::post('{id}/upload-images', [
				'as'	=> 'item.upload.doImages',
				'uses'	=> 'ItemController@doImagesUpload']);

			Route::get('{id}/download/{fileId}', [
				'as'	=> 'item.download',
				'uses'	=> 'ItemController@download']);
			
			Route::post('{id}/report-issue', [
				'as'	=> 'item.reportIssue',
				'uses'	=> 'ItemController@reportIssue']);
			Route::post('{id}/report-abuse', [
				'as'	=> 'item.reportAbuse',
				'uses'	=> 'ItemController@reportAbuse']);
			
			Route::get('{author}/{slug}', [
				'as'	=> 'item.show',
				'uses'	=> 'ItemController@show']);

			Route::post('ajax/checkName', [
				'as'	=> 'item.ajax.checkName',
				'uses'	=> 'ItemController@ajaxCheckName']);
		});
	}

	protected function accountRoutes()
	{
		Route::group(['before' => 'auth', 'namespace' => 'Xtras\Controllers'], function()
		{
			Route::get('profile/{name}', array(
				'as'	=> 'account.profile',
				'uses'	=> 'UserController@show'
			));
			Route::get('account/edit/{slug}', array(
				'as'	=> 'account.edit',
				'uses'	=> 'UserController@edit'
			));
			Route::get('my-xtras', [
				'as'	=> 'account.xtras',
				'uses'	=> 'UserController@xtras']);
			Route::resource('account', 'UserController');
		});
	}

	protected function miscRoutes()
	{
		Route::group(['before' => 'auth', 'namespace' => 'Xtras\Controllers'], function()
		{
			Route::get('comments/{itemId}', 'CommentController@index');
			Route::post('comments/{itemId}', 'CommentController@store');
		});
	}

	protected function adminRoutes()
	{
		$groupOptions = [
			'before'	=> 'auth',
			'prefix'	=> 'admin',
			'namespace' => 'Xtras\Controllers\Admin'
		];

		Route::group($groupOptions, function()
		{
			Route::get('/', [
				'as'	=> 'admin',
				'uses'	=> 'AdminController@index']);

			Route::get('products/{id}/remove', 'ProductsController@remove');
			Route::get('types/{id}/remove', 'TypesController@remove');

			Route::resource('users', 'UsersController', ['except' => ['show']]);
			Route::resource('products', 'ProductsController', ['except' => ['show']]);
			Route::resource('types', 'TypesController', ['except' => ['show']]);
			Route::resource('items', 'ItemsController', ['except' => ['show']]);
		});
	}

}