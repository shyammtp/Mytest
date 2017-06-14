<?php

Route::set('restapi', '<controller>(/<param>)',array('format' => '(json|xml|csv|html)'))
	->defaults(array(
        'directory' => 'api',
		'format' => 'json'));  
 