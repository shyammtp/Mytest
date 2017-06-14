<?php
defined('SYSPATH') OR die('No direct script access.');

return array(
    'dashboard' => array(
        'title' => 'Dashboard',
        'sort' => '1',
    ),
    'system' => array(
        'title' => 'Settings',
        'sort' => '2',  
        'children' => array(
            'general' => array(
                'title' => 'General',
                'sort' => '1',        
            ), 
        ),
    ),
);
