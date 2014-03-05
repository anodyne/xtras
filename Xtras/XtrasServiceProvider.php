<?php namespace Xtras;

use Illuminate\Support\ServiceProvider;

class XtrasServiceProvider extends ServiceProvider {

	public function register()
	{
		//
	}

	public function boot()
	{
		$this->setupBindings();

		// Markdown

		// Browser

		// S3
	}

	protected function setupBindings()
	{
		// Get the class aliases
		$a = $this->app['config']->get('app.aliases');

		$this->app->bind($a['XtraRepositoryInterface'], $a['XtraRepository']);
		$this->app->bind($a['UserRepositoryInterface'], $a['UserRepository']);
	}

}