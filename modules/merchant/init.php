<?php defined('SYSPATH') or die('No direct script access.');

// Catch-all route for Codebench classes to run
Route::set('frontuser', '<route>(/<controller>(/<action>(/<id>)))',array('route' => 'user'))
	->defaults(array(
        'directory' => 'user',
		'controller' => 'account',
		'action' => 'index'));