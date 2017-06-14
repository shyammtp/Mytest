<?php
defined('SYSPATH') OR die('No direct script access.');

return array(
    'dashboard' => array(
        'title' => 'Dashboard',
        'sort' => '1',
        'url' => 'admin/dashboard/index',
        'index' => 'admin/dashboard/index',
        'before' => '<i class="fa fa-dashboard"></i>',
        'after' => '',
    ), 
    'settings' => array(
        'title' => 'Settings',
        'sort' => '200',
        'before' => '<i class="fa fa-anchor"></i>',
        'after' => '',
        'children' => array(
            'general' => array(
                'title' => 'General',
                'sort' => '1',
                'url' => 'admin/settings/general',
                'before' => '',
                'after' => '',
            ),
           /* 'users' => array(
				'title' => 'Users',
				'sort' => '2',
				'after' => '',
					'children' => array(
						'users_template' => array(
						'title' => 'User Email Templates',
						'sort' => '9',
						'url' => 'admin/settings/users_templates',
						'before' => '',
						'after' => '',
						),
						'users_settings' => array(
						'title' => 'User Settings',
						'sort' => '2',
						'url' => 'admin/settings/users_settings',
						'before' => '',
						'after' => '',
						),
				),
            ), */
            'email' => array(
                'title' => 'Email',
                'sort' => '4',
                'url' => 'admin/settings/email',
                'before' => '',
                'after' => '',
            ),
            'notificationtemplates' => array(
                'title' => 'Notification Templates',
                'sort' => '5',
                'url' => 'admin/template/email',
                'before' => '',
                'after' => '',
            ),
           /* 'social_media' => array(
                'title' => 'Social Media',
                'sort' => '6',
                'url' => 'admin/settings/social_media',
                'before' => '',
                'after' => '',
            ),
            'currency_settings' => array(
                'title' => 'Currency Settings',
                'sort' => '7',
                'url' => 'admin/settings/currency_settings',
                'before' => '',
                'after' => '',
            ),*/
			'language_settings' => array(
                'title' => 'Language Settings',
                'sort' => '8',
                'url' => 'admin/settings/language_settings',
                'before' => '',
                'after' => '',
            ),
           'cache' => array(
                'title' => 'Import',
                'sort' => '215',
                'url' => 'admin/settings/cache',
                'before' => '',
                'after' => '',
            ), 
        ),
    ),/*
    'permissions' => array(
        'title' => 'Permission',
        'sort' => '500',
        'before' => '<i class="fa fa-desktop"></i>',
        'after' => '',
		'children' => array(
			'roles' => array(
				'title' => 'Roles',
				'sort' => '1',
				'url' => 'admin/system_permission_roles/index',
			),
			'users' => array(
				'title' => 'Users',
				'sort' => '2',
				'url' => 'admin/system_permission_users/index',
			),
		),
    ),*/
   
); 
