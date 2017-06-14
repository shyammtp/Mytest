<?php defined('SYSPATH') or die('No direct script access.');
defined('ROUTE') or define('ROUTE','store'); 
// Catch-all route for Codebench classes to run

Route::set('storeadmin', '<route>(/<controller>(/<action>(/<id>)))',array('route' => ROUTE))
	->defaults(array(
        'directory' => 'store',
		'controller' => 'index',
		'action' => 'login'));
 
