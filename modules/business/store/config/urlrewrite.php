<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
    'rewrites' => array(
        'store/login.html' => array(
            'routename' => 'storeadmin_login', 
            'path' => 'store/index/login',
        ),
        'store/dashboard.do' => array(
            'routename' => 'default', 
            'path' => 'store/dashboard/index', //Directory/Controller/Action
        ),
    )
);