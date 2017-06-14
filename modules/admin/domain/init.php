<?php defined('SYSPATH') or die('No direct script access.'); 

// Catch-all route for Codebench classes to run
Route::set('domain', '<route>(/<controller>(/<action>(/<id>)))',array('route' => 'domain'))
	->defaults(array(
        'directory' => 'domain',
		'controller' => 'list',
		'action' => 'website'));