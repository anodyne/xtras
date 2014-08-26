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
	}

	protected function pagesRoutes()
	{
		Route::group(['namespace' => 'Xtras\Controllers'], function()
		{
			Route::get('/', [
				'as'		=> 'home',
				'uses'		=> 'MainController@index']);

			Route::get('skins', [
				'as'		=> 'skins',
				'uses'		=> 'ItemController@skins']);
			Route::get('ranks', [
				'as'		=> 'ranks',
				'uses'		=> 'ItemController@ranks']);
			Route::get('mods', [
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
			'prefix'	=> 'search',
			'namespace' => 'Xtras\Controllers'
		];

		Route::group($groupOptions, function()
		{
			Route::get('/', [
				'as'	=> 'search.do',
				'uses'	=> 'SearchController@doSearch']);
			Route::get('advanced', [
				'as'	=> 'search.advanced',
				'uses'	=> 'SearchController@advanced']);
			Route::get('advanced-results', [
				'as'	=> 'search.doAdvanced',
				'uses'	=> 'SearchController@doAdvancedSearch']);
		});
	}

	protected function itemRoutes()
	{
		$groupOptions = [
			'prefix'	=> 'item',
			'namespace' => 'Xtras\Controllers'
		];

		Route::group($groupOptions, function()
		{
			Route::get('create', [
				'before'	=> 'auth',
				'as'		=> 'item.create',
				'uses'		=> 'ItemController@create']);
			Route::post('/', [
				'before'	=> 'auth',
				'as'		=> 'item.store',
				'uses'		=> 'ItemController@store']);

			Route::get('{author}/{slug}/edit', [
				'before'	=> 'auth',
				'as'		=> 'item.edit',
				'uses'		=> 'ItemController@edit']);
			Route::put('{id}', [
				'before'	=> 'auth',
				'as'		=> 'item.update',
				'uses'		=> 'ItemController@update']);

			Route::delete('{id}', [
				'before'	=> 'auth',
				'as'		=> 'item.destroy',
				'uses'		=> 'ItemController@destroy']);

			Route::get('{id}/upload', [
				'before'	=> 'auth',
				'as'		=> 'item.upload',
				'uses'		=> 'ItemController@upload']);
			Route::post('{id}/upload-zip', [
				'before'	=> 'auth',
				'as'		=> 'item.upload.doZip',
				'uses'		=> 'ItemController@doZipUpload']);
			Route::post('{id}/upload-images', [
				'before'	=> 'auth',
				'as'		=> 'item.upload.doImages',
				'uses'		=> 'ItemController@doImagesUpload']);

			Route::get('{id}/download/{fileId}', [
				'before'	=> 'auth',
				'as'		=> 'item.download',
				'uses'		=> 'ItemController@download']);
			
			Route::post('{id}/report-issue', [
				'before'	=> 'auth',
				'as'		=> 'item.reportIssue',
				'uses'		=> 'ItemController@reportIssue']);
			Route::post('{id}/report-abuse', [
				'before'	=> 'auth',
				'as'		=> 'item.reportAbuse',
				'uses'		=> 'ItemController@reportAbuse']);
			
			Route::get('{author}/{slug}', [
				'as'	=> 'item.show',
				'uses'	=> 'ItemController@show']);

			Route::post('ajax/checkName', [
				'before'	=> 'auth',
				'as'		=> 'item.ajax.checkName',
				'uses'		=> 'ItemController@ajaxCheckName']);
		});
	}

	protected function accountRoutes()
	{
		Route::group(['namespace' => 'Xtras\Controllers'], function()
		{
			Route::get('profile/{name}', array(
				'as'	=> 'account.profile',
				'uses'	=> 'UserController@show'
			));
			Route::get('my-xtras', [
				'before'	=> 'auth',
				'as'		=> 'account.xtras',
				'uses'		=> 'UserController@xtras']);
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
			Route::get('products/{id}/remove', 'ProductsController@remove');
			Route::get('types/{id}/remove', 'TypesController@remove');

			Route::resource('products', 'ProductsController', ['except' => ['show']]);
			Route::resource('types', 'TypesController', ['except' => ['show']]);
			Route::resource('items', 'ItemsController', ['except' => ['show']]);
		});
	}

}