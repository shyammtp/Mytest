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
    'view_doctor/detail' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'doctordetail' => array(
                        'type' => 'Front/View/Doctor',
                        'template' => 'view/doctor',
                         'children' => array(
							'searchbar' => array(
									'type' => 'Front/View/Searchbar',
									'template' => 'search/bar',
							 ),
                            'photos' => array(
                                'type' => 'Front/View/Doctor',
								'template' => 'view/clinic/photos',
                            ),
                            'breadcrumbs' => array (
                                'type' => 'Front/Breadcrumb',
                                'template' => 'page/breadcrumbs',
                                'actions' => array(
                                    'homeaction1' => array(
                                        'method' => 'addCrumb',
                                        'attributes' => array(
                                            'crumbname' => 'home',
                                            'crumbinfo' => array('link' => '/','label' => __('Home'),'title' => __('Home')),
                                        ),
                
                                    ),
                                ),
                            ),
                            'bookappointment' => array(
                                'type' => 'Front/User/Book',
                                'template' => 'user/book'
                            )
						 ), 
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Users',
                ),
                'actions' => array(
                    'appendThemeJs' => array( 
                        'src' => array('js/select2.min.js','js/moment.min.js','plugins/autocomplete/jquery.autocomplete.js','js/jquery-ui-1.10.3.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('plugins/autocomplete/jquery.autocomplete.css','css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),         
			
        ),
    ),
    'view_clinic/list' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'clinicdetail' => array(
                        'type' => 'Front/View/Clinic',
                        'template' => 'view/clinic/list',
                         'children' => array(
							'searchbar' => array(
									'type' => 'Front/View/Searchbar',
									'template' => 'search/bar',
							 )  
						 ), 
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
    'view_clinic/detail' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'clinicdetail' => array(
                        'type' => 'Front/View/Clinic',
                        'template' => 'view/clinic',
                        'children' => array(
							'searchbar' => array(
									'type' => 'Front/View/Searchbar',
									'template' => 'search/bar',
							 ),
                            'photos' => array(
                                'type' => 'Front/View/Clinic',
								'template' => 'view/clinic/photos',
                            ),
                            'breadcrumbs' => array (
                                'type' => 'Front/Breadcrumb',
                                'template' => 'page/breadcrumbs',
                                'actions' => array(
                                    'homeaction1' => array(
                                        'method' => 'addCrumb',
                                        'attributes' => array(
                                            'crumbname' => 'home',
                                            'crumbinfo' => array('link' => '/','label' => __('Home'),'title' => __('Home')),
                                        ),
                
                                    ),
                                ),
                            ),
						 ), 
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Users',
                ),
                'actions' => array(
                    'appendThemeJs' => array( 
                        'src' => array('js/select2.min.js','plugins/autocomplete/jquery.autocomplete.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('plugins/autocomplete/jquery.autocomplete.css','css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),         
			
        ),
    ), 
    'view_lab/list' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'lablist' => array(
                        'type' => 'Front/View/Lab',
                        'template' => 'view/lab',
                         'children' => array(
							'searchbar' => array(
									'type' => 'Front/View/Searchbar',
									'template' => 'search/bar',
							 )  
						 ), 
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Lab',
                ),
                'actions' => array(
                    'appendThemeJs' => array( 
                        'src' => array('js/select2.min.js','plugins/autocomplete/jquery.autocomplete.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('plugins/autocomplete/jquery.autocomplete.css','css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),         
			
        ),
    ), 
    'view_lab/detail' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'labdetail' => array(
                        'type' => 'Front/View/Lab',
                         'template' => 'view/lab/detail',
                        'children' => array(
							'searchbar' => array(
									'type' => 'Front/View/Searchbar',
									'template' => 'search/bar',
							 )  
						 ), 
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Lab',
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
    'view_insurance/list' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'clinicdetail' => array(
                        'type' => 'Front/View/Insurance',
                        'template' => 'view/insurance/list',
                         'children' => array(
							'searchbar' => array(
									'type' => 'Front/View/Searchbar',
									'template' => 'search/bar',
							 )  
						 ), 
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
    'view_insurance/detail' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'clinicdetail' => array(
                        'type' => 'Front/View/Insurance',
                        'template' => 'view/insurance',
                        'children' => array(
							'searchbar' => array(
									'type' => 'Front/View/Searchbar',
									'template' => 'search/bar',
							 )  
						 ), 
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
);
