<?php namespace Xtras;

use App,
	Auth,
	View,
	Event,
	Config;
use Parsedown;
use Aws\S3\S3Client;
use Ikimea\Browser\Browser;
use League\Flysystem\Filesystem,
	League\Flysystem\Adapter\AwsS3,
	League\Flysystem\Adapter\Local;
use Illuminate\Support\ServiceProvider;

class XtrasServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->registerBrowser();
		$this->registerMarkdown();
		$this->registerFilesystem();
		$this->registerEvents();
		$this->registerFlashNotifier();
	}

	public function boot()
	{
		$this->checkBrowser();
		$this->setupBindings();
	}

	protected function checkBrowser()
	{
		$this->app->before(function($request)
		{
			// Get the browser object
			$browser = App::make('xtras.browser');

			$supported = array(
				Browser::BROWSER_IE			=> 9,
				Browser::BROWSER_CHROME		=> 26,
				Browser::BROWSER_FIREFOX	=> 20,
			);

			if (array_key_exists($browser->getBrowser(), $supported) 
					and $browser->getVersion() < $supported[$browser->getBrowser()])
			{
				header("Location: browser.php");
				die();
			}
		});
	}

	protected function setupBindings()
	{
		// Get the class aliases
		$a = $this->app['config']->get('app.aliases');

		// Set up bindings from the interface to their concrete classes
		App::bind($a['ItemRepositoryInterface'], 'Xtras\Repositories\Eloquent\ItemRepository');
		App::bind($a['OrderRepositoryInterface'], 'Xtras\Repositories\Eloquent\OrderRepository');
		App::bind($a['ProductRepositoryInterface'], 'Xtras\Repositories\Eloquent\ProductRepository');
		App::bind($a['TypeRepositoryInterface'], 'Xtras\Repositories\Eloquent\TypeRepository');
		App::bind($a['UserRepositoryInterface'], 'Xtras\Repositories\Eloquent\UserRepository');

		// Make sure we some variables available on all views
		View::share('_currentUser', Auth::user());
		View::share('_icons', Config::get('icons'));
	}

	protected function registerBrowser()
	{
		$this->app['xtras.browser'] = $this->app->share(function($app)
		{
			return new Browser;
		});
	}

	protected function registerFilesystem()
	{
		$this->app['xtras.filesystem'] = $this->app->share(function($app)
		{
			switch ($app->environment())
			{
				case 'local':

					return new Filesystem(new Local($_ENV['FS_LOCAL_PATH']));

				break;

				case 'production':

					$client = S3Client::factory(array(
						'key'		=> $_ENV['FS_S3_KEY'],
						'secret'	=> $_ENV['FS_S3_SECRET'],
					));

					return new Filesystem(new AwsS3($client, $_ENV['FS_S3_BUCKET'], $_ENV['FS_S3_PREFIX']));

				break;
			}
		});
	}

	protected function registerMarkdown()
	{
		$this->app['markdown'] = $this->app->share(function($app)
		{
			return new Services\MarkdownService(new Parsedown);
		});
	}

	protected function registerEvents()
	{
		Event::listen('item.created', 'Xtras\Events\ItemEventHandler@onCreate');
		Event::listen('item.comment', 'Xtras\Events\ItemEventHandler@onComment');
		Event::listen('item.deleted', 'Xtras\Events\ItemEventHandler@onDelete');
		Event::listen('item.updated', 'Xtras\Events\ItemEventHandler@onUpdate');
		Event::listen('item.uploaded', 'Xtras\Events\ItemEventHandler@onUpload');
		Event::listen('item.report.abuse', 'Xtras\Events\ItemEventHandler@onReportAbuse');
		Event::listen('item.report.issue', 'Xtras\Events\ItemEventHandler@onReportIssue');

		Event::listen('user.created', 'Xtras\Events\UserEventHandler@onCreate');
		Event::listen('user.deleted', 'Xtras\Events\UserEventHandler@onDelete');
		Event::listen('user.registered', 'Xtras\Events\UserEventHandler@onRegister');
		Event::listen('user.updated', 'Xtras\Events\UserEventHandler@onUpdate');

		Event::listen('product.created', 'Xtras\Events\ProductEventHandler@onCreate');
		Event::listen('product.deleted', 'Xtras\Events\ProductEventHandler@onDelete');
		Event::listen('product.updated', 'Xtras\Events\ProductEventHandler@onUpdate');

		Event::listen('type.created', 'Xtras\Events\TypeEventHandler@onCreate');
		Event::listen('type.deleted', 'Xtras\Events\TypeEventHandler@onDelete');
		Event::listen('type.updated', 'Xtras\Events\TypeEventHandler@onUpdate');
	}

	protected function registerFlashNotifier()
	{
		$this->app['xtras.flash'] = $this->app->share(function($app)
		{
			return new Services\FlashNotiferService($app['session.store']);
		});
	}

}