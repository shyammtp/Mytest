<?php
defined('SYSPATH') OR die('No direct script access.');

return array(
	
	 'appointments' => array(
        'title' => 'Appointments',
        'sort' => '2',
        'children' => array(
            'appointment' => array(
				'title' => 'Appointment Lists',
                'sort' => '1',
				'task_note' => 'Manage the appointment lists',
				'task_index' => '["admin/appointments/index"]',
				
				),
			), 
    ),
    
    'countrysettings' => array(
        'title' => 'Directory',
        'sort' => '1',
        'children' => array(
            'country' => array(
				'title' => 'Country management',
                'sort' => '1',
				'task_note' => 'Country lists',
				'task_index' => '["admin/settings/countrysettings"]',
				 
			),
            'countryedit' => array(
				'title' => 'Edit Country manage',
                'sort' => '2',
				'task_note' => 'Edit and delete Country',
				'task_index' => '["admin/settings/editcountry","admin/settings/deletecountry","admin/settings/savecountry"]',
				
			),
			'city' => array(
				'title' => 'City management',
                'sort' => '3',
				'task_note' => 'City lists',
				'task_index' => '["admin/settings/citysettings"]',
				
			),
			'cityedit' => array(
				'title' => 'Edit city manage',
                'sort' => '4',
				'task_note' => 'Edit and delete City',
				'task_index' => '["admin/settings/editcity","admin/settings/deletecity","admin/settings/savecity"]',
				
			),
			'area' => array(
				'title' => 'Area management',
                'sort' => '5',
				'task_note' => 'Area lists',
				'task_index' => '["admin/settings/areasettings"]',
				
			),
			'areaedit' => array(
				'title' => 'Edit and manage area',
                'sort' => '6',
				'task_note' => 'Edit Area',
				'task_index' => '["admin/settings/editarea","admin/settings/deletearea","admin/settings/savearea"]',
				
			),
			  
		),	
    ),
    
    'banner_settings' => array(
        'title' => 'Banners',
        'sort' => '3',
        'children' => array(
            'banner' => array(
				'title' => 'Banners management',
                'sort' => '1',
				'task_note' => 'Banners lists',
				'task_index' => '["admin/settings/banner_settings"]',
				 
				),
		
            'banneredit' => array(
				'title' => 'Edit Banners management',
                'sort' => '2',
				'task_note' => 'Edit and delete banners',
				'task_index' => '["admin/settings/edit_banner","admin/settings/delete_banner","admin/settings/savebanner"]',
				
				),
		), 
    ),
    
    'department' => array(
        'title' => 'Department',
        'sort' => '4',
        'children' => array(
            'departments' => array(
				'title' => 'Department management',
                'sort' => '1',
				'task_note' => 'Department lists',
				'task_index' => '["admin/department/index"]',
				 
				),
			
            'editdepartments' => array(
				'title' => 'Edit Department management',
                'sort' => '2',
				'task_note' => 'Edit and delete department',
				'task_index' => '["admin/department/editdepartment","admin/department/savedepartment","admin/department/deletedepartment"]',
				
				),
			), 
    ),
    
    'insurance' => array(
        'title' => 'Insurance',
        'sort' => '5',
        'children' => array(
            'insurances' => array(
				'title' => 'Insurance management',
                'sort' => '1',
				'task_note' => 'Insurance lists',
				'task_index' => '["admin/insurance/index"]',
				 
				),
            'editinsurances' => array(
				'title' => 'Edit insurance management',
                'sort' => '2',
				'task_note' => 'Edit Insurance',
				'task_index' => '["admin/insurance/editinsurance","admin/insurance/deleteinsurance"]',
				 
				),
			), 
    ),
    
    'permissions' => array(
        'sort' => '2',
        'title' => 'Permissions',
        'children' => array(
            'roles' => array(
                'title' => 'Roles',
                'sort' => '2',
                'task_note' => 'Managing the role lists',
                'task_index' => '["admin/system_permission_roles/index","admin/system_permission_roles/ajax","admin/system_permission_roles/deleterole","admin/system_permission_roles/storeroles"]',
            ),
            'roles/edit' => array(
                'title' => 'Roles Edit',
                'sort' => '3',
                'task_note' => 'Edit the roles and their tasks',
                'task_index' => '["admin/system_permission_roles/edit","admin/system_permission_roles/new","admin/system_permission_roles/tasks","admin/system_permission_roles/saverole","admin/system_permission_roles/save"]'
            ),
            'users' => array(
                'title' => 'Roles Users',
                'sort' => '4',
                'task_note' => 'Managing the role users lists',
                'task_index' => '["admin/system_permission_users/index","admin/system_permission_users/ajax","admin/system_permission_users/deleterole_users","admin/system_permission_users/storeroleusers"]',
            ),
            'edit' => array(
                'title' => 'Roles User Edit',
                'sort' => '5',
                'task_note' => 'Edit the role users and their tasks',
                'task_index' => '["admin/system_permission_users/edit","admin/system_permission_users/new","admin/system_permission_users/tasks","admin/system_permission_users/save","admin/system_permission_users/deleterole_users","admin/users/list"]'
            ),
        ),
    ),
    
    'settings' => array(
        'title' => 'Settings',
        'sort' => '4',
		'children' => array(
			'general' => array(
				'title' => 'General Settings',
				'sort' => '1',
				'task_note' => 'Managing the general settings',
				'task_index' => '["admin/settings/general","admin/configuration/save"]',
				
			),
			'email' => array(
				'title' => 'Email Settings',
				'task_note' => 'Managing the emial settings',
				'task_index' => '["admin/settings/email","admin/configuration/save"]',
				'sort' => '13'
			), 
			'language_settings' => array(
				'title' => 'Language Settings',
				'task_note' => 'Managing the language settings',
				'task_index' => '["admin/settings/language_settings","admin/settings/edit_language","admin/settings/savelanguage"]',
				'sort' => '17'
			),
			'notificationtemplates' => array(
				'title' => 'Notification Template',
				'task_note' => 'Manage Notification Subject',
				'task_index' => '["admin/template/email","admin/template/ajaxtemplatelist"]',
				'sort' => '20'
			),												  
		)
    ), 
    
    'medical_places' => array(
        'title' => 'Medical Places',
        'sort' => '100', 
        'children' => array(
            'clinic' => array(
                'title' => 'Clinic Management',
                'sort' => '100',
                'task_index' => '["admin/clinic/index"]',  
                'task_note' => 'Manage clinic'
            ),
            'hospital' => array(
                'title' => 'Hospital Management',
                'sort' => '103',
                'task_index' => '["admin/clinic/index"]',  
                'task_note' => 'Manage hospital'
            ),
            'pharmacy' => array(
                'title' => 'Pharmacy Management',
                'sort' => '104',
                'task_index' => '["admin/clinic/index"]',  
                'task_note' => 'Manage pharmacy'
            ),
            'labs' => array(
                'title' => 'Labs Management',
                'sort' => '102',
                'task_index' => '["admin/clinic/index"]', 
                'task_note' => 'Manage labs'
            ),
            'optics' => array(
                'title' => 'Optics Management',
                'sort' => '105',
                'task_index' => '["admin/clinic/index"]',
                'task_note' => 'Manage optics'
            ),
        )
    ),
    'users' => array(
        'sort' => '2',
        'title' => 'User Management',
        'children' => array(
            'user/doctor' => array(
                'title' => 'Doctor Lists',
                'sort' => '1',
                'task_note' => 'Managing the doctor lists',
                'task_index' => '["admin/users/index","admin/users/doctorlist"]',
            ),
            'user/editdoctor' => array(
                'title' => 'Edit Doctor',
                'sort' => '2',
                'task_note' => 'Add,Edit and delete doctor management',
                'task_index' => '["admin/users/index","admin/users/doctoredit","admin/users/edit","admin/users/save","admin/users/addvideo","admin/users/settimings","admin/users/delete","admin/settings/getcity","admin/settings/getarea"]',
            ),
             'user/patient' => array(
                'title' => 'Patient Lists',
                'sort' => '3',
                'task_note' => 'Managing the patient lists',
                'task_index' => '["admin/users/index","admin/users/patientlist"]',
            ),
            'user/editpatient' => array(
                'title' => 'Edit Patient',
                'sort' => '4',
                'task_note' => 'Add,Edit and delete patient management',
                'task_index' => '["admin/users/index","admin/users/patientedit","admin/users/edit","admin/users/save","admin/users/addvideo","admin/users/settimings","admin/users/delete","admin/settings/getcity","admin/settings/getarea"]',
            ),
            'user/adminuser' => array(
                'title' => 'Admin Users Lists',
                'sort' => '5',
                'task_note' => 'Managing the admin users lists',
                'task_index' => '["admin/users/index","admin/users/adminuserlist"]',
            ),
            'user/editadminuser' => array(
                'title' => 'Edit Admin Users',
                'sort' => '6',
                'task_note' => 'Add, Edit and delete admin users management',
                'task_index' => '["admin/users/index","admin/users/adminuseredit","admin/users/edit","admin/users/save","admin/users/addvideo","admin/users/settimings","admin/users/delete","admin/settings/getcity","admin/settings/getarea"]',
            ),
        ),
    ),
    
);
