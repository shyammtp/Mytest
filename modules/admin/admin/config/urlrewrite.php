<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
    'rewrites' => array(
        'login.html' => array(
            'routename' => 'admin',
            'directory' => 'admin',
            'controller' => 'index',
            'action' => 'index',
            'path' => 'admin/index/index',
        ),
        /*'admin/dashboard.do' => array(
            'routename' => 'admin', 
            'path' => 'admin/dashboard/index',
            'additionalparams' => array('id' => '20')
        ),*/
        'admin/settings.do' => array(
            'routename' => 'admin', 
            'path' => 'admin/settings/index', 
        ),
        'admin/system/cache.do' => array(
            'routename' => 'system_cache', 
            'path' => 'admin/system/cache', 
        ),
    )
);
