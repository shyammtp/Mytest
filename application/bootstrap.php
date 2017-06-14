<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/Kohana/Core'.EXT;

if (is_file(APPPATH.'classes/Kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/Kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/Kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Asia/Calcutta');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');
ini_set("session.cache_limiter", "must-revalidate");

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

if (isset($_SERVER['SERVER_PROTOCOL']))
{
	// Replace the default protocol.
	HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{ 
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */ 
Kohana::init(array(
	'base_url'   => '/',
	'index_file' => false,
	'cache_life' => '86400',
	'profile' => Kohana::$environment == Kohana::PRODUCTION ? false: true,
	'errors' => Kohana::$environment == Kohana::PRODUCTION ? false : true,
	'caching' => Kohana::$environment == Kohana::PRODUCTION ? true : false	
));
 
/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

Cookie::$salt = 'foobar';

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	// 'auth'       => MODPATH.'auth',       // Basic authentication
	 'cache'      => MODPATH.'cache',      // Caching with multiple backends
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	 'database'   => MODPATH.'database',   // Database access
	 'image'      => MODPATH.'image',      // Image manipulation
	// 'minion'     => MODPATH.'minion',     // CLI Tasks
	// 'orm'        => MODPATH.'orm',        // Object Relationship Mapping
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
	'cron'       => MODPATH.'cron',
	'core'		=> MODPATH.'core',
	'notice' => MODPATH.'notice',
	//'api' => MODPATH.'api',
	'dataflow' => MODPATH.'dataflow',
	'entity' => MODPATH.'entity',
	//'company' => MODPATH.'company',
	//'education' => MODPATH.'education',
	//'bstore' => MODPATH.'store',
	'user' => MODPATH.'user',
	'directory' => MODPATH.'directory',
	//'developerbar' => MODPATH.'developerbar-kohana-3.2',
	//'property' => MODPATH.'property',
	'excel' => MODPATH.'excel',
	//'products' => MODPATH.'products',
	//'services_open' => MODPATH.'services',
	'logviewer' => MODPATH.'logviewer',
	//'religious' => MODPATH.'religious',
	//'search' => MODPATH.'search',
	//'parking' => MODPATH.'parking',
	'imagecache' => MODPATH.'imagecache',
	'cms' => MODPATH.'cms',
	//'cart' => MODPATH.'cart',
	//'healthcare' => MODPATH.'healthcare',
	//'factsheet' => MODPATH.'factsheet',
	//'garden' => MODPATH.'garden',
	//'shortlists' => MODPATH.'shortlists',
	//'rating' => MODPATH.'rating',
	//'peoples' => MODPATH.'peoples',
	//'places' => MODPATH.'places',
	'locations' => MODPATH.'locations',
	'merchant' => MODPATH.'merchant',
	//'insurance' => MODPATH.'insurance',
	//'clinic' => MODPATH.'clinic',
	//'reports' => MODPATH.'reports',
	//'subscription' => MODPATH.'subscription',
	//'banner' => MODPATH.'banner',
));

// For review
Route::set('search', '(<insurance>/)search/(<city>/)<type>(/q(/<keyword>))',array('type' => 'doctor|clinic|hospital|labs|pharmacy|optics'))
	->defaults(array(
		'controller' => 'search',
		'action' => 'search'));
Route::set('acc', 'profile/<username>/account(/<action>)',array('username' => '.*'))
	->defaults(array(
		'controller' => 'account',
		'action' => 'edit')); 
	 
Cron::set('clear_cache_garbage', array('0 12 * * *', array(App::model('core/cache'),'cleargarbage'))); 
Cron::set('send_notification', array('*/5 * * * *', array(App::model('core/event'),'sendnotification')));
 

defined('ENABLE_MEMCACHED') or define('ENABLE_MEMCACHED',false);
defined('ENABLE_FILECACHE') or define('ENABLE_FILECACHE',false);

defined('DATABASE_CACHE_LIFETIME') or define('DATABASE_CACHE_LIFETIME',-1);
defined('SMALL_RECORDS_DATABASE_CACHE_LIFETIME') or define('SMALL_RECORDS_DATABASE_CACHE_LIFETIME',-1);

//Exception ERROR Codes
defined('ERROR_INVALID_PRODUCT') or define('ERROR_INVALID_PRODUCT',21);
defined('ERROR_INVALID_STORE') or define('ERROR_INVALID_STORE',53);
defined('ERROR_INVALID_CITY') or define('ERROR_INVALID_CITY',6);
defined('ERROR_INVALID_USER') or define('ERROR_INVALID_USER',52);
defined('ERROR_INVALID_ORDER') or define('ERROR_INVALID_ORDER',12);
defined('ERROR_GENERAL') or define('ERROR_GENERAL',100);
defined('ERROR_NEED_LOGIN') or define('ERROR_NEED_LOGIN',11);
defined('ERROR_MISSING_PARAMETER') or define('ERROR_MISSING_PARAMETER',46);    
defined('ERROR_INVALID_PARAMETER') or define('ERROR_INVALID_PARAMETER',445);
defined('ERROR_MISSING_PARAMETER_VALUE') or define('ERROR_MISSING_PARAMETER_VALUE',47);
