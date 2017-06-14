<?php 
/*
 * array starting index will be used on rendered to the controller. In here "content" is first index.
 *
 * Eg: $block->getBlock('content');
 *
 *
 * indexes,
 * - type (Required) = will be the block class which needs to be in classes/Blocks folder.
 *       For eg: classes/Blocks/Front/Template.php define as "Front/Template"
 * - template (optional) - If doesnt defined here need to define in the constructor of the block class.
 * - Children (optional) -  Children will be used to access the block and template inside another block.
 * - attributes (optional) - Values can get into the template file or block file using setter and getter method.
 */

return array(
    'account/settings' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/profile',  
            ),
            'maincontent' => array(
                'children' => array(
                    'settings' => array(
                        'type' => 'Front/Account',
                        'template' => 'account/settings',
                         
                    ),        
                                 
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'My settings',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js','js/bootstrap-checkbox.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'user_profile',
                            'crumbinfo' => array('label' => __('My settings'),'title' => __('My settings')),
                        ), 
                    ),
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'settings',
                ),
            ),
        ),
    ),
    'account/appointments' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/profile',  
            ),
            'maincontent' => array(
                'children' => array(
                    'settings' => array(
                        'type' => 'Front/Account/Appointments/Doctor',
                        'template' => 'account/appointments',                         
                    ),
                    'patient' => array(
                        'type' => 'Front/Account/Appointments/Patient',
                        'template' => 'account/appointments/patient',                         
                    ),
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'My appointments',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js','js/bootstrap-checkbox.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'user_profile',
                            'crumbinfo' => array('label' => __('My appointments'),'title' => __('My appointments')),
                        ), 
                    ),
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'appointments',
                ),
            ),
        ),
    ),
    'account/reports' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/profile',  
            ),
            'maincontent' => array(
                'children' => array(
                    'reports' => array(
                        'type' => 'Front/Account/Report',
                        'template' => 'account/reports', 
                    ), 
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'My appointments',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js','js/bootstrap-checkbox.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'user_profile',
                            'crumbinfo' => array('label' => __('My appointments'),'title' => __('My appointments')),
                        ), 
                    ),
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'appointments',
                ),
            ),
        ),
    ),
    'account/reportajax' => array(
        'content' => array(
            'children' => array(
                'reports' => array( 
                    'type' => 'Front/Account/Report',
                    'template' => 'account/reportsajax', 
                )
            ),
        )
    ),
     'account/appreportajax' => array(
        'content' => array(
            'children' => array(
                'reports' => array( 
                    'type' => 'Front/Account/Report',
                    'template' => 'account/appreportsajax', 
                )
            ),
        )
    ),
    'account/timings' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/profile',  
            ),
            'maincontent' => array(
                'children' => array(
                    'timings' => array(
                        'type' => 'Front/Account/Timings',
                        'template' => 'account/timings',                         
                    ), 
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'My timings',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js','js/bootstrap-timepicker.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/bootstrap-timepicker.min.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'user_profile',
                            'crumbinfo' => array('label' => __('My timings'),'title' => __('My timings')),
                        ), 
                    ),
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'timings',
                ),
            ),
        ),
    ),
    'account/media' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/profile',  
            ),
            'maincontent' => array(
                'children' => array(
                    'timings' => array(
                        'type' => 'Front/Account/Media',
                        'template' => 'account/media',
                        'children' => array(
                            'photos' => array(
                                'type' => 'Front/Account/Media',
                                'template' => 'account/media/photos',
                            ),
                            'videos' => array(
                                'type' => 'Front/Account/Media',
                                'template' => 'account/media/videos',
                            ),
                        )
                    ), 
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'My media',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('plugins/fileinput/js/fileinput.min.js','js/select2.min.js','js/bootstrap-timepicker.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('plugins/fileinput/css/fileinput.min.css','css/bootstrap-timepicker.min.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'user_profile',
                            'crumbinfo' => array('label' => __('My media'),'title' => __('My media')),
                        ), 
                    ),
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'photos',
                ),
            ),
        ),
    ),
    'account/viewappointments' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/profile',  
            ),
            'maincontent' => array(
                'children' => array(
                    'viewappointments' => array(
                        'type' => 'Front/Account',
                        'template' => 'account/appointments/view',   
                        'children' => array(
							'receivedAppointments' => array(
								'type' => 'Front/Account',
								'template' => 'account/appointments/received_appointments',
                                'children' => array(
                                    'bookappointment' => array(
                                        'type' => 'Front/User/Book',
                                        'template' => 'user/editbook'
                                    )
                                )
							), 
							'bookedAppointments' => array(
								'type' => 'Front/Account',
								'template' => 'account/appointments/booked_appointments',
                                'children' => array(
                                    'bookappointment' => array(
                                        'type' => 'Front/User/Book',
                                        'template' => 'user/editbook'
                                    )
                                )
							), 
						),                      
                    ), 
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'View appointment',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js','plugins/autocomplete/jquery.autocomplete.js','js/moment.min.js','js/bootstrap-checkbox.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('plugins/autocomplete/jquery.autocomplete.css','css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                   
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'appointments',
                ),
            ),
        ),
    ),
    'report/generate' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/1column',  
            ),
            'maincontent' => array(
                'children' => array(
                    'report_form' => array(
                        'type' => 'Front/Account/Appointments/Report',
                        'template' => 'account/appointments/report_form',
                        'children' => array(
                            'labreport' => array(
                                'type' => 'Front/Account/Appointments/Report',
                                'template' => 'account/appointments/report/lab',
                            ),
                            'doctorreport' => array(
                                'type' => 'Front/Account/Appointments/Report',
                                'template' => 'account/appointments/report/doctor',
                            ),
                        ),
                    ),
                ),
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Reports',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js','js/moment.min.js','js/bootstrap-checkbox.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                   
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'appointments',
                ),
            ),
        ),
    ),
    
    'report/view' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/1column',  
            ),
            'maincontent' => array(
                'children' => array(
                    'report_form' => array(
                        'type' => 'Front/Account/Appointments/Report/View',
                        'template' => 'account/appointments/report/view'
                    ),
                ),
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Reports',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js','js/moment.min.js','js/bootstrap-checkbox.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                   
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'appointments',
                ),
            ),
        ),
    ),
    'report/viewapp' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/empty',  
            ),
            'maincontent' => array(
                'children' => array(
                    'report_form' => array(
                        'type' => 'Front/Account/Appointments/Report/View',
                        'template' => 'account/appointments/report/view'
                    ),
                ),
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Reports',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js','js/moment.min.js','js/bootstrap-checkbox.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                   
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'appointments',
                ),
            ),
        ),
    ),
    'report/edit' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/1column',  
            ),
            'maincontent' => array(
                'children' => array(
                    'report_form' => array(
                        'type' => 'Front/Account/Appointments/Report/Edit',
                        'template' => 'account/appointments/report/edit'
                    ),
                ),
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'My media',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('plugins/fileinput/js/fileinput.min.js','js/select2.min.js','js/bootstrap-timepicker.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('plugins/fileinput/css/fileinput.min.css','css/bootstrap-timepicker.min.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                   
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'appointments',
                ),
            ),
        ),
    ),
    'report/editapp' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/empty',  
            ),
            'maincontent' => array(
                'children' => array(
                    'report_form' => array(
                        'type' => 'Front/Account/Appointments/Report/Edit',
                        'template' => 'account/appointments/report/edit'
                    ),
                ),
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'My media',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('plugins/fileinput/js/fileinput.min.js','js/select2.min.js','js/bootstrap-timepicker.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('plugins/fileinput/css/fileinput.min.css','css/bootstrap-timepicker.min.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                   
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'appointments',
                ),
            ),
        ),
    ),
    'report/user' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/empty',  
            ),
            'maincontent' => array(
                'children' => array(
                    'reports' => array(
                        'type' => 'Front/Account/Report',
                        'template' => 'account/appreports',                         
                    ),
                ),
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Reports',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js','js/moment.min.js','js/bootstrap-checkbox.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                   
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'appointments',
                ),
            ),
        ),
    ),
    'report/export' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/empty',  
            ),
            'maincontent' => array(
                'children' => array(
                    'report_table_set' => array(
                        'type' => 'Front/Account/Appointments/Report/View',
                        'template' => 'account/appointments/report/view'
                    ),
                ),
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Reports',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js','js/moment.min.js','js/bootstrap-checkbox.min.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                   
                ),
            ), 
            'topmenu' => array(
                'attributes' => array(
                    'active' => 'appointments',
                ),
            ),
        ),
    ),
);
