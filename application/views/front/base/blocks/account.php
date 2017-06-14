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
    'account/edit' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/profile',  
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('plugins/switch/js/bootstrap-switch.min.js','plugins/autocomplete/jquery.autocomplete_forother.js','js/jquery-ui-1.10.3.min.js','js/custom.js','js/bootstrap-wysihtml5.js','plugins/fileinput/js/fileinput.min.js','js/bootstrap-timepicker.min.js','js/select2.min.js'),
                    ),

                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'profilepage' => array(
                        'type' => 'Front/Account',
                        'template' => 'account/edit_profile',
                        'children' => array(
							'doctorprofilepage' => array(
								'type' => 'Front/Account',
								'template' => 'account/edit_profile_doctor',
								'children' => array(
										'countrycityarea' => array(
											'type' => 'Front/Countrycityarea',
											'template' => 'country/countrycityarea',
										),
								 ),
							),
							'patientprofilepage' => array(
								'type' => 'Front/Account',
								'template' => 'account/edit_profile_patient',
								'children' => array(
										'countrycityarea' => array(
											'type' => 'Front/Countrycityarea',
											'template' => 'country/countrycityarea',
										),
								 ),
							),
                        
                        ),
                    ),        
                                 
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Edit Profile',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('media/picturecut/jquery.picture.cut.js','plugins/autocomplete/jquery.autocomplete.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css','css/jquery-ui-1.10.3.css','plugins/switch/css/bootstrap3/bootstrap-switch.min.css','css/bootstrap-wysihtml5.css','plugins/fileinput/css/fileinput.min.css','css/bootstrap-timepicker.min.css','plugins/autocomplete/jquery.autocomplete.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'edit_profile',
                            'crumbinfo' => array('label' => __('Edit Profile'),'title' => __('Edit Profile')),
                        ), 
                    ),
                ),
            ),
             'topmenu' => array(
               'attributes' => array(
                   'active' => 'edit',
               ),
           ),
			
        ),
    ),
    
      'account/signupsuccess' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'profilepage' => array(
                        'type' => 'Front/Account',
                        'template' => 'account/signup_success',
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Users',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),         
			
        ),
    ),
    'account/welcome' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'profilepage' => array(
                        'type' => 'Front/Account',
                        'template' => 'account/welcome',
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Users',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),         
			
        ),
    ),
    
    'account/signin' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'signin' => array(
                        'type' => 'Front/Account',
                        'template' => 'signin',
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Sign In',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),         
			
        ),
    ),
    'account/signup' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'signuppage' => array(
                        'type' => 'Front/Account',
                        'template' => 'signup',
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Sign Up',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),         
			
        ),
    ),
    'account/doctorsignup' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'doctorsignup' => array(
                        'type' => 'Front/Account',
                        'template' => 'doctor_signup',
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Users',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),         
			
        ),
    ),
    'account/getcity' => array(
        'content' => array(
            'children' => array(
                'city' => array(
                     'type' => 'Front/Countrycityarea',
                     'template' => 'country/city'
                ),
            ),           
        ),
    ),     
    'account/getarea' => array(
        'content' => array(
            'children' => array(
                'area' => array(
                     'type' => 'Front/Countrycityarea',
                     'template' => 'country/area'
                ),
            ),           
        ),
    ),
    'account/changepassword' => array(
        'reference' => array(
			'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/profile',  
            ),
            'maincontent' => array(
                'children' => array(
                    'changepassword' => array(
                        'type' => 'Front/Account',
                        'template' => 'account/change_password',
                    ),                    
                )
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Message / System - Admin',
                ),
                'actions' => array(
                    'appendThemeCss' => array(
                        'src' => array('plugins/search/jquery.autocomplete.css'),
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Change password',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('media/picturecut/jquery.picture.cut.js','plugins/autocomplete/jquery.autocomplete.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css','css/jquery-ui-1.10.3.css','plugins/switch/css/bootstrap3/bootstrap-switch.min.css','css/bootstrap-wysihtml5.css','plugins/fileinput/css/fileinput.min.css','css/bootstrap-timepicker.min.css','plugins/autocomplete/jquery.autocomplete.css')
                    ),
                ),
            ),
            'topmenu' => array(
               'attributes' => array(
                   'active' => 'edit',
               ),
           ),
			
        ),
    ),
    'account/generatereport' => array(
        'reference' => array(
            'content' => array( 
                'type'  => 'Front/Page',
                'template' => 'column/profile',  
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('plugins/switch/js/bootstrap-switch.min.js','plugins/autocomplete/jquery.autocomplete_forother.js','js/jquery-ui-1.10.3.min.js','js/custom.js','js/bootstrap-wysihtml5.js','plugins/fileinput/js/fileinput.min.js','js/bootstrap-timepicker.min.js','js/select2.min.js'),
                    ),

                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'profilepage' => array(
						'type' => 'Front/Account',
                        'template' => 'account/appointments/report/newreport',
                    ),            
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Generate Report',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('media/picturecut/jquery.picture.cut.js','plugins/autocomplete/jquery.autocomplete.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css','css/jquery-ui-1.10.3.css','plugins/switch/css/bootstrap3/bootstrap-switch.min.css','css/bootstrap-wysihtml5.css','plugins/fileinput/css/fileinput.min.css','css/bootstrap-timepicker.min.css','plugins/autocomplete/jquery.autocomplete.css')
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'generate_report',
                            'crumbinfo' => array('label' => __('Generate Report'),'title' => __('Generate Report')),
                        ), 
                    ),
                ),
            ),
             'topmenu' => array(
               'attributes' => array(
                   'active' => 'generate_report',
               ),
           ),
			
        ),
    ),
    
);
