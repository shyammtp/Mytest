<?php
defined('SYSPATH') OR die('No direct script access.');

return array(
		'dashboard' => array(
			'title' => 'Dashboard',
			'sort' => '1',
			'url' => 'store/dashboard/index',
			'before' => '<i class="fa fa-dashboard"></i>',
			'after' => '',
		),
        'settings' => array(
            'title' => 'Settings',
            'sort' => '203',
            'before' => '<i class="fa fa-cog"></i>',
            'after' => '',
            'children' => array(
                'general' => array(
                    'title' => 'General',
                    'sort' => '1',
                    'url' => 'store/settings/general',
                    'before' => '',
                    'after' => '',
                ),
            ),
        ), 
		/*'insurance' => array(
			'title' => 'Insurance',
			'sort' => '2',
			'url' => 'insurance/index',
			'before' => '<i class="fa fa-envelope"></i>',
			'after' => '',
		),*/
		/*'import' => array(
                'title' => 'Import',
                'sort' => '4',
                'url' => 'dashboard/import',
                'before' => '<i class="fa fa-upload"></i>',
                'after' => '',
         ),
         'users' => array(
                'title' => 'Doctors',
                'sort' => '3',
                'url' => 'users/index',
                'before' => '<i class="fa fa-user"></i>',
                'after' => '',
         ),
		'medical_places' => array(
        'title' => 'Medical Places',
        'sort' => '2', 
        'before' => '<i class="fa fa-plus-square"></i>',
        'after' => '',
        'children' => array(
            'clinic' => array(
                'title' => 'Clinic',
                'sort' => '1',
                'url' => 'clinic/index',  
                'query' => array('type' => 1)
            ),
            'hospital' => array(
                'title' => 'Hospital',
                'sort' => '2',
                'url' => 'clinic/index',  
                'query' => array('type' => 2)
            ),
            'pharmacy' => array(
                'title' => 'Pharmacy',
                'sort' => '3',
                'url' => 'clinic/index',  
                'query' => array('type' => 4)
            ),
            'labs' => array(
                'title' => 'Labs',
                'sort' => '4',
                'url' => 'clinic/index', 
                'query' => array('type' => 3)
            ),
            'optics' => array(
                'title' => 'Optics',
                'sort' => '5',
                'url' => 'clinic/index',
                'query' => array('type' => 5)
            ),
        )
    ),*/
    
);
