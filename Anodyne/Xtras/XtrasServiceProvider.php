<?php namespace Xtras;

use App,
	Auth,
	View,
	Event,
	Config;
use ParsedownExtra;
use Ikimea\Browser\Browser;
use League\Flysystem\Filesystem,
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
		$this->registerSanitizer();
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
			$browser = App::make('browser');

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
		$a = Config::get('app.aliases');

		// Set up bindings from the interface to their concrete classes
		App::bind($a['ItemRepositoryInterface'], $a['ItemRepository']);
		App::bind($a['OrderRepositoryInterface'], $a['OrderRepository']);
		App::bind($a['ProductRepositoryInterface'], $a['ProductRepository']);
		App::bind($a['TypeRepositoryInterface'], $a['TypeRepository']);
		App::bind($a['UserRepositoryInterface'], $a['UserRepository']);

		// Make sure we some variables available on all views
		View::share('_currentUser', Auth::user());
		View::share('_icons', Config::get('icons'));
		View::share('_browser', App::make('browser'));
	}

	protected function registerBrowser()
	{
		$this->app['browser'] = $this->app->share(function($app)
		{
			return new Browser;
		});
	}

	protected function registerFilesystem()
	{
		$this->app['xtras.filesystem'] = $this->app->share(function($app)
		{
			return new Filesystem(new Local($_ENV['FS_PATH']));
		});
	}

	protected function registerMarkdown()
	{
		$this->app['markdown'] = $this->app->share(function($app)
		{
			return new Services\MarkdownService(new ParsedownExtra);
		});
	}

	protected function registerEvents()
	{
		// Set the namespace
		$namespace = 'Xtras\\Events\\';

		Event::listen('item.created', "{$namespace}ItemEventHandler@onCreate");
		Event::listen('item.comment', "{$namespace}ItemEventHandler@onComment");
		Event::listen('item.deleted', "{$namespace}ItemEventHandler@onDelete");
		Event::listen('item.updated', "{$namespace}ItemEventHandler@onUpdate");
		Event::listen('item.notify', "{$namespace}ItemEventHandler@notifyForNewVersion");
		
		Event::listen('item.file.deleted', "{$namespace}ItemEventHandler@onFileDelete");
		Event::listen('item.file.uploaded', "{$namespace}ItemEventHandler@onFileUpload");

		Event::listen('item.image.deleted', "{$namespace}ItemEventHandler@onImageDelete");
		Event::listen('item.image.uploaded', "{$namespace}ItemEventHandler@onImageUpload");
		
		Event::listen('item.report.abuse', "{$namespace}ItemEventHandler@onReportAbuse");
		Event::listen('item.report.issue', "{$namespace}ItemEventHandler@onReportIssue");
		
		Event::listen('item.message.created', "{$namespace}ItemEventHandler@onMessageCreate");
		Event::listen('item.message.deleted', "{$namespace}ItemEventHandler@onMessageDelete");
		Event::listen('item.message.updated', "{$namespace}ItemEventHandler@onMessageUpdate");

		Event::listen('product.created', "{$namespace}ProductEventHandler@onCreate");
		Event::listen('product.deleted', "{$namespace}ProductEventHandler@onDelete");
		Event::listen('product.updated', "{$namespace}ProductEventHandler@onUpdate");

		Event::listen('type.created', "{$namespace}TypeEventHandler@onCreate");
		Event::listen('type.deleted', "{$namespace}TypeEventHandler@onDelete");
		Event::listen('type.updated', "{$namespace}TypeEventHandler@onUpdate");
	}

	protected function registerFlashNotifier()
	{
		$this->app['flash'] = $this->app->share(function($app)
		{
			return new Services\FlashNotifierService($app['session.store']);
		});
	}

	protected function registerSanitizer()
	{
		$this->app['sanitizer'] = $this->app->share(function($app)
		{
			return new Services\SanitizerService;
		});
	}

}