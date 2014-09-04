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
			'uses'	=> 'Xtras\Controllers\LoginController@index']);
		Route::post('login', [
			'as'	=> 'login.do',
			'uses'	=> 'Xtras\Controllers\LoginController@doLogin']);
		Route::get('logout', [
			'as'	=> 'logout',
			'uses'	=> 'Xtras\Controllers\LoginController@logout']);
	}

	protected function pagesRoutes()
	{
		Route::group(['namespace' => 'Xtras\Controllers'], function()
		{
			Route::get('/', [
				'as'	=> 'home',
				'uses'	=> 'MainController@index']);

			Route::get('skins', [
				'as'	=> 'skins',
				'uses'	=> 'Items\ItemController@skins']);
			Route::get('ranks', [
				'as'	=> 'ranks',
				'uses'	=> 'Items\ItemController@ranks']);
			Route::get('mods', [
				'as'		=> 'mods',
				'uses'		=> 'Items\ItemController@mods']);

			Route::get('policies/{type?}', [
				'as'	=> 'policies',
				'uses'	=> 'MainController@policies']);
			Route::get('faq', [
				'as'	=> 'faq',
				'uses'	=> 'MainController@faq']);
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
		$messagesOptions = [
			'before'	=> 'auth',
			'prefix'	=> 'item/messages',
			'namespace' => 'Xtras\Controllers\Items'
		];

		Route::group($messagesOptions, function()
		{
			Route::get('{author}/{slug}/create', [
				'as'	=> 'item.messages.create',
				'uses'	=> 'MessagesController@create']);
			Route::post('{author}/{slug}', [
				'as'	=> 'item.messages.store',
				'uses'	=> 'MessagesController@store']);
			Route::get('{id}/edit', [
				'as'	=> 'item.messages.edit',
				'uses'	=> 'MessagesController@edit']);
			Route::put('{id}', [
				'as'	=> 'item.messages.update',
				'uses'	=> 'MessagesController@update']);
			Route::get('{author}/{slug}', [
				'as'	=> 'item.messages.index',
				'uses'	=> 'MessagesController@index']);
		});
		
		$filesOptions = [
			'before'	=> 'auth',
			'prefix'	=> 'item/files',
			'namespace' => 'Xtras\Controllers\Items'
		];

		Route::group($filesOptions, function()
		{
			Route::get('{author}/{slug}/create', [
				'as'	=> 'item.files.create',
				'uses'	=> 'FilesController@create']);
			Route::post('{itemId}/upload', [
				'as'	=> 'item.files.upload',
				'uses'	=> 'FilesController@upload']);
			Route::get('{fileId}/remove', [
				'as'	=> 'item.files.remove',
				'uses'	=> 'FilesController@remove']);
			Route::delete('{fileId}', [
				'as'	=> 'item.files.destroy',
				'uses'	=> 'FilesController@destroy']);
			Route::get('{author}/{slug}', [
				'as'	=> 'item.files.index',
				'uses'	=> 'FilesController@index']);
		});

		$imagesOptions = [
			'before'	=> 'auth',
			'prefix'	=> 'item/images',
			'namespace' => 'Xtras\Controllers\Items'
		];

		Route::group($imagesOptions, function()
		{
			Route::post('{itemId}/{image}/upload', [
				'as'	=> 'item.images.upload',
				'uses'	=> 'ImagesController@upload']);
			Route::get('{itemId}/{imageNumber}/remove', [
				'as'	=> 'item.images.remove',
				'uses'	=> 'ImagesController@remove']);
			Route::delete('{itemId}/{imageNumber}', [
				'as'	=> 'item.images.destroy',
				'uses'	=> 'ImagesController@destroy']);
			Route::post('make-primary', [
				'as'	=> 'item.images.primary',
				'uses'	=> 'ImagesController@primary']);
			Route::get('{author}/{slug}', [
				'as'	=> 'item.images.index',
				'uses'	=> 'ImagesController@index']);
		});

		$adminOptions = [
			'prefix'	=> 'item',
			'namespace' => 'Xtras\Controllers\Items'
		];

		Route::group($adminOptions, function()
		{
			Route::get('admin', [
				'before'	=> 'auth',
				'as'		=> 'item.admin',
				'uses'		=> 'AdminController@index']);
			Route::get('create', [
				'before'	=> 'auth',
				'as'		=> 'item.create',
				'uses'		=> 'AdminController@create']);
			Route::post('/', [
				'before'	=> 'auth',
				'as'		=> 'item.store',
				'uses'		=> 'AdminController@store']);
			Route::get('{author}/{slug}/edit/{admin?}', [
				'before'	=> 'auth',
				'as'		=> 'item.edit',
				'uses'		=> 'AdminController@edit']);
			Route::put('{author}/{slug}/{admin?}', [
				'before'	=> 'auth',
				'as'		=> 'item.update',
				'uses'		=> 'AdminController@update']);
			Route::get('{itemId}/remove/{admin?}', [
				'before'	=> 'auth',
				'as'		=> 'item.remove',
				'uses'		=> 'AdminController@remove']);
			Route::delete('{itemId}/{admin?}', [
				'before'	=> 'auth',
				'as'		=> 'item.destroy',
				'uses'		=> 'AdminController@destroy']);

			Route::get('{author}/{slug}/download/{fileId}', [
				'before'	=> 'auth',
				'as'		=> 'item.download',
				'uses'		=> 'ItemController@download']);
			
			Route::post('{author}/{slug}/report-issue', [
				'before'	=> 'auth',
				'as'		=> 'item.reportIssue',
				'uses'		=> 'ItemController@reportIssue']);
			Route::post('{author}/{slug}/report-abuse', [
				'before'	=> 'auth',
				'as'		=> 'item.reportAbuse',
				'uses'		=> 'ItemController@reportAbuse']);
			
			Route::get('ajax/checkName/{name}', [
				'before'	=> 'auth',
				'as'		=> 'item.ajax.checkName',
				'uses'		=> 'AdminController@ajaxCheckName']);
			Route::post('ajax/rate', [
				'before'	=> 'auth',
				'as'		=> 'item.ajax.rate',
				'uses'		=> 'ItemController@ajaxStoreRating']);

			Route::get('comments/{itemId}', [
				'before'	=> 'auth',
				'uses'		=> 'CommentsController@index']);
			Route::post('comments/{itemId}', [
				'before'	=> 'auth',
				'uses'		=> 'CommentsController@store']);

			Route::get('{author}/{slug}', [
				'as'	=> 'item.show',
				'uses'	=> 'ItemController@show']);
		});
	}

	protected function accountRoutes()
	{
		Route::group(['namespace' => 'Xtras\Controllers'], function()
		{
			Route::get('profile/{name}', [
				'as'	=> 'account.profile',
				'uses'	=> 'UserController@show']);
			Route::get('my-xtras', [
				'before'	=> 'auth',
				'as'		=> 'account.xtras',
				'uses'		=> 'UserController@xtras']);
			Route::get('notifications', [
				'before'	=> 'auth',
				'as'		=> 'account.notifications',
				'uses'		=> 'UserController@notifications']);
			Route::post('notifications/add', [
				'before'	=> 'auth',
				'as'		=> 'account.notifications.add',
				'uses'		=> 'UserController@addNotification']);
			Route::post('notifications/remove', [
				'before'	=> 'auth',
				'as'		=> 'account.notifications.remove',
				'uses'		=> 'UserController@removeNotification']);
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
		});
	}

}