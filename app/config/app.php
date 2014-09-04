<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

	'debug' => false,

	/*
	|--------------------------------------------------------------------------
	| Application URL
	|--------------------------------------------------------------------------
	|
	| This URL is used by the console to properly generate URLs when using
	| the Artisan command line tool. You should set this to the root of
	| your application so that it is used when running Artisan tasks.
	|
	*/

	'url' => 'http://localhost',

	/*
	|--------------------------------------------------------------------------
	| Application Timezone
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default timezone for your application, which
	| will be used by the PHP date and date-time functions. We have gone
	| ahead and set this to a sensible default for you out of the box.
	|
	*/

	'timezone' => 'America/New_York',

	/*
	|--------------------------------------------------------------------------
	| Application Locale Configuration
	|--------------------------------------------------------------------------
	|
	| The application locale determines the default locale that will be used
	| by the translation service provider. You are free to set this value
	| to any of the locales which will be supported by the application.
	|
	*/

	'locale' => 'en',

	/*
	|--------------------------------------------------------------------------
	| Encryption Key
	|--------------------------------------------------------------------------
	|
	| This key is used by the Illuminate encrypter service and should be set
	| to a random, 32 character string, otherwise these encrypted strings
	| will not be safe. Please do this before deploying an application!
	|
	*/

	'key' => $_ENV['APP_KEY'],

	'cipher' => MCRYPT_RIJNDAEL_128,

	/*
	|--------------------------------------------------------------------------
	| Autoloaded Service Providers
	|--------------------------------------------------------------------------
	|
	| The service providers listed here will be automatically loaded on the
	| request to your application. Feel free to add your own services to
	| this array to grant expanded functionality to your applications.
	|
	*/

	'providers' => array(

		'Illuminate\Foundation\Providers\ArtisanServiceProvider',
		'Illuminate\Auth\AuthServiceProvider',
		'Illuminate\Cache\CacheServiceProvider',
		'Illuminate\Session\CommandsServiceProvider',
		'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider',
		'Illuminate\Routing\ControllerServiceProvider',
		'Illuminate\Cookie\CookieServiceProvider',
		'Illuminate\Database\DatabaseServiceProvider',
		'Illuminate\Encryption\EncryptionServiceProvider',
		'Illuminate\Filesystem\FilesystemServiceProvider',
		'Illuminate\Hashing\HashServiceProvider',
		'Illuminate\Html\HtmlServiceProvider',
		'Illuminate\Log\LogServiceProvider',
		'Illuminate\Mail\MailServiceProvider',
		'Illuminate\Database\MigrationServiceProvider',
		'Illuminate\Pagination\PaginationServiceProvider',
		'Illuminate\Queue\QueueServiceProvider',
		'Illuminate\Redis\RedisServiceProvider',
		'Illuminate\Remote\RemoteServiceProvider',
		'Illuminate\Auth\Reminders\ReminderServiceProvider',
		'Illuminate\Database\SeedServiceProvider',
		'Illuminate\Session\SessionServiceProvider',
		'Illuminate\Translation\TranslationServiceProvider',
		'Illuminate\Validation\ValidationServiceProvider',
		'Illuminate\View\ViewServiceProvider',
		'Illuminate\Workbench\WorkbenchServiceProvider',

		'Xtras\XtrasServiceProvider',
		'Xtras\XtrasRoutingServiceProvider',
		'Zizaco\Entrust\EntrustServiceProvider',
		'Intervention\Image\ImageServiceProvider',

	),

	/*
	|--------------------------------------------------------------------------
	| Service Provider Manifest
	|--------------------------------------------------------------------------
	|
	| The service provider manifest is used by Laravel to lazy load service
	| providers which are not needed for each request, as well to keep a
	| list of all of the services. Here, you may set its storage spot.
	|
	*/

	'manifest' => storage_path().'/meta',

	/*
	|--------------------------------------------------------------------------
	| Class Aliases
	|--------------------------------------------------------------------------
	|
	| This array of class aliases will be registered when this application
	| is started. However, feel free to register as many as you wish as
	| the aliases are "lazy" loaded so they don't hinder performance.
	|
	*/

	'aliases' => array(

		'App'             => 'Illuminate\Support\Facades\App',
		'Artisan'         => 'Illuminate\Support\Facades\Artisan',
		'Auth'            => 'Illuminate\Support\Facades\Auth',
		'Blade'           => 'Illuminate\Support\Facades\Blade',
		'Cache'           => 'Illuminate\Support\Facades\Cache',
		'ClassLoader'     => 'Illuminate\Support\ClassLoader',
		'Config'          => 'Illuminate\Support\Facades\Config',
		'Controller'      => 'Illuminate\Routing\Controller',
		'Cookie'          => 'Illuminate\Support\Facades\Cookie',
		'Crypt'           => 'Illuminate\Support\Facades\Crypt',
		'DB'              => 'Illuminate\Support\Facades\DB',
		'Eloquent'        => 'Illuminate\Database\Eloquent\Model',
		'Event'           => 'Illuminate\Support\Facades\Event',
		'File'            => 'Illuminate\Support\Facades\File',
		'Form'            => 'Illuminate\Support\Facades\Form',
		'Hash'            => 'Illuminate\Support\Facades\Hash',
		'HTML'            => 'Illuminate\Support\Facades\HTML',
		'Input'           => 'Illuminate\Support\Facades\Input',
		'Lang'            => 'Illuminate\Support\Facades\Lang',
		'Log'             => 'Illuminate\Support\Facades\Log',
		'Mail'            => 'Illuminate\Support\Facades\Mail',
		'Paginator'       => 'Illuminate\Support\Facades\Paginator',
		'Password'        => 'Illuminate\Support\Facades\Password',
		'Queue'           => 'Illuminate\Support\Facades\Queue',
		'Redirect'        => 'Illuminate\Support\Facades\Redirect',
		'Redis'           => 'Illuminate\Support\Facades\Redis',
		'Request'         => 'Illuminate\Support\Facades\Request',
		'Response'        => 'Illuminate\Support\Facades\Response',
		'Route'           => 'Illuminate\Support\Facades\Route',
		'Schema'          => 'Illuminate\Support\Facades\Schema',
		'Seeder'          => 'Illuminate\Database\Seeder',
		'Session'         => 'Illuminate\Support\Facades\Session',
		'SSH'             => 'Illuminate\Support\Facades\SSH',
		'Str'             => 'Illuminate\Support\Str',
		'URL'             => 'Illuminate\Support\Facades\URL',
		'Validator'       => 'Illuminate\Support\Facades\Validator',
		'View'            => 'Illuminate\Support\Facades\View',

		/**
		 * Classes
		 */
		'BaseController'	=> 'Xtras\Controllers\BaseController',
		'Browser'			=> 'Ikimea\Browser\Browser',
		'Date'				=> 'Carbon\Carbon',
		'Entrust'			=> 'Zizaco\Entrust\EntrustFacade',
		'Flash'				=> 'Xtras\Foundation\Facades\FlashFacade',
		'Gravatar'			=> 'forxer\Gravatar\Gravatar',
		'Image'				=> 'Intervention\Image\Facades\Image',
		'Markdown'			=> 'Xtras\Foundation\Facades\MarkdownFacade',
		'Model'				=> 'Xtras\Extensions\Laravel\Database\Eloquent\Model',
		
		/**
		 * Models
		 */
		'ProductModel'		=> 'Xtras\Foundation\Data\Models\Eloquent\ProductModel',
		'UserModel'			=> 'Xtras\Foundation\Data\Models\Eloquent\UserModel',
		'ItemModel'			=> 'Xtras\Foundation\Data\Models\Eloquent\ItemModel',
		'ItemFileModel'		=> 'Xtras\Foundation\Data\Models\Eloquent\ItemFileModel',
		'ItemMessageModel'	=> 'Xtras\Foundation\Data\Models\Eloquent\ItemMessageModel',
		'ItemMetaModel'		=> 'Xtras\Foundation\Data\Models\Eloquent\ItemMetaModel',
		'ItemRatingModel'	=> 'Xtras\Foundation\Data\Models\Eloquent\ItemRatingModel',
		'TypeModel'			=> 'Xtras\Foundation\Data\Models\Eloquent\TypeModel',
		'CommentModel'		=> 'Xtras\Foundation\Data\Models\Eloquent\CommentModel',
		'NotificationModel'	=> 'Xtras\Foundation\Data\Models\Eloquent\NotificationModel',
		'OrderModel'		=> 'Xtras\Foundation\Data\Models\Eloquent\OrderModel',
		'RoleModel'			=> 'Xtras\Foundation\Data\Models\Eloquent\RoleModel',
		'PermissionModel'	=> 'Xtras\Foundation\Data\Models\Eloquent\PermissionModel',

		/**
		 * Repository Interfaces
		 */
		'ItemRepositoryInterface'		=> 'Xtras\Foundation\Data\Interfaces\ItemRepositoryInterface',
		'OrderRepositoryInterface'		=> 'Xtras\Foundation\Data\Interfaces\OrderRepositoryInterface',
		'ProductRepositoryInterface'	=> 'Xtras\Foundation\Data\Interfaces\ProductRepositoryInterface',
		'TypeRepositoryInterface'		=> 'Xtras\Foundation\Data\Interfaces\TypeRepositoryInterface',
		'UserRepositoryInterface'		=> 'Xtras\Foundation\Data\Interfaces\UserRepositoryInterface',

		/**
		 * Repositories
		 */
		'ItemRepository'	=> 'Xtras\Foundation\Data\Repositories\Eloquent\ItemRepository',
		'OrderRepository'	=> 'Xtras\Foundation\Data\Repositories\Eloquent\OrderRepository',
		'ProductRepository'	=> 'Xtras\Foundation\Data\Repositories\Eloquent\ProductRepository',
		'TypeRepository'	=> 'Xtras\Foundation\Data\Repositories\Eloquent\TypeRepository',
		'UserRepository'	=> 'Xtras\Foundation\Data\Repositories\Eloquent\UserRepository',

		/**
		 * Traits
		 */
		'UtilityTrait'	=> 'Xtras\Traits\UtilityTrait',

		/**
		 * Mailers
		 */
		'ItemMailer'	=> 'Xtras\Mailers\ItemMailer',

		/**
		 * Transformers
		 */
		'CommentTransformer'	=> 'Xtras\Transformers\CommentTransformer',

		/**
		 * Validators
		 */
		'ItemCreationValidator'	=> 'Xtras\Validators\ItemCreationValidator',
		'ItemUpdateValidator'	=> 'Xtras\Validators\ItemUpdateValidator',

		/**
		 * Exceptions
		 */
		'FormValidationException'	=> 'Xtras\Exceptions\FormValidationException',

	),

);