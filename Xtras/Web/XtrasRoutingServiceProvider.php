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

		Route::get('policies/{type?}', [
			'as'	=> 'policies',
			'uses'	=> 'Xtras\Controllers\MainController@policies']);
		Route::get('faq', [
			'as'	=> 'faq',
			'uses'	=> 'Xtras\Controllers\MainController@faq']);

		/**
		 * Xtras
		 */
		Route::group(array('before' => 'auth'), function()
		{
			Route::get('/', array(
				'as'	=> 'home',
				'uses'	=> 'Xtras\Controllers\MainController@index'
			));

			Route::get('skins', [
				'as'	=> 'skins',
				'uses'	=> 'Xtras\Controllers\ItemController@skins']);
			Route::get('ranks', [
				'as'	=> 'ranks',
				'uses'	=> 'Xtras\Controllers\ItemController@ranks']);
			Route::get('mods', [
				'as'	=> 'mods',
				'uses'	=> 'Xtras\Controllers\ItemController@mods']);

			Route::get('item/{id}/upload', [
				'as'	=> 'item.upload',
				'uses'	=> 'Xtras\Controllers\ItemController@upload']);
			Route::post('item/{id}/upload-zip', [
				'as'	=> 'item.upload.doZip',
				'uses'	=> 'Xtras\Controllers\ItemController@doZipUpload']);
			Route::post('item/{id}/upload-images', [
				'as'	=> 'item.upload.doImages',
				'uses'	=> 'Xtras\Controllers\ItemController@doImagesUpload']);
			Route::get('item/{id}/download/{fileId}', [
				'as'	=> 'item.download',
				'uses'	=> 'Xtras\Controllers\ItemController@download']);
			Route::post('item/ajax/checkName', [
				'as'	=> 'item.ajax.checkName',
				'uses'	=> 'Xtras\Controllers\ItemController@ajaxCheckName']);
			Route::post('item/{id}/report-issue', [
				'as'	=> 'item.reportIssue',
				'uses'	=> 'Xtras\Controllers\ItemController@reportIssue']);
			Route::post('item/{id}/report-abuse', [
				'as'	=> 'item.reportAbuse',
				'uses'	=> 'Xtras\Controllers\ItemController@reportAbuse']);
			Route::post('item/{id}/add-comment', [
				'as'	=> 'item.addComment',
				'uses'	=> 'Xtras\Controllers\ItemController@storeComment']);
			Route::resource('item', 'Xtras\Controllers\ItemController');
			Route::get('item/{author}/{slug}', [
				'as'	=> 'item.show',
				'uses'	=> 'Xtras\Controllers\ItemController@show']);

			Route::get('profile/{name}', array(
			'as'	=> 'account.profile',
			'uses'	=> 'Xtras\Controllers\UserController@show'
		));
			Route::get('account/edit/{slug}', array(
				'as'	=> 'account.edit',
				'uses'	=> 'Xtras\Controllers\UserController@edit'
			));
			Route::get('account/xtras', [
				'as'	=> 'account.xtras',
				'uses'	=> 'Xtras\Controllers\UserController@xtras']);
			Route::resource('account', 'Xtras\Controllers\UserController');

			Route::get('results', [
				'as'	=> 'search.results',
				'uses'	=> 'Xtras\Controllers\SearchController@results']);
			Route::get('advanced-search', [
				'as'	=> 'search.advanced',
				'uses'	=> 'Xtras\Controllers\SearchController@advanced']);
			Route::post('search', [
				'as'	=> 'search.do',
				'uses'	=> 'Xtras\Controllers\SearchController@doSearch']);
			Route::post('search-advanced', [
				'as'	=> 'search.doAdvanced',
				'uses'	=> 'Xtras\Controllers\SearchController@doAdvancedSearch']);
		});
	}

}