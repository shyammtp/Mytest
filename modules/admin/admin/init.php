<?php defined('SYSPATH') or die('No direct script access.'); 
 
 // Catch-all route for Codebench classes to run
Route::set('masteradmin', '<route>(/<controller>(/<action>(/<id>)))',array('route' => 'admin'))
	->defaults(array(
        'directory' => 'admin',
		'controller' => 'index',
		'action' => 'login'));