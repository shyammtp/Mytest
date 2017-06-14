<?php
$blockname = 'users';
/*
 * array starting index will be used on rendered to the controller. In here "content" is first index.
 *
 * Eg: $block->getBlock('content');
 *
 *
 * indexes,
 * - type (Required) = will be the block class which needs to be in classes/Blocks folder.
 *       For eg: classes/Blocks/Front/Template.php define as "Front/Template"
 * - template (optional) - If it doesnt defined here, you can define in the constructor of the block class.
 * - Children (optional) -  Children will be used to access the block and template inside another block.
 * - attributes (optional) - Values can get into the template file or block file using setter and getter method.
 *  - Eg:
 *          attributes => array('static' => 'Good one','static_index2' => 'Another good' )
 *          In Template file or in the block class,
 *              $this->getStatic(); // Returns Good one
 *              $this->getStaticIndex2(); // Returns Another good
 *
 * - actions (optional) - Method to call from the block
 * Reference is used to call a reference index in default block set (from default.php file)
 * with the reference you can extend children blocks
 */

return array(
	'store/users/index' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'users',
                ),
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/custom.js'),
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'title_icon' => '<i class="fa fa-user" ></i>&nbsp;',
                    'page_title' => 'Users',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Users',
                ),
                'actions' => array(
                    'appendThemeCss' => array(
                        'src' => array('css/colorpicker.css'),
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'users_list_wrapper' => array(
                        'type' => 'Store/Page',
                        'template' => 'store/users/users',
                        'children' => array(
                            'user_listing' => array(
                                'type' => 'Store/Users/List',
                            ),
                        ),
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'users',
                            'crumbinfo' => array('label' => 'Doctors','title' => 'Doctors'),
                        ),

                    ),
                ),
            ),
        ),
    ),
    
    
    'store/users/edit' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'users',
                ),
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('plugins/switch/js/bootstrap-switch.min.js','plugins/autocomplete/jquery.autocomplete.js','js/jquery-ui-1.10.3.min.js','js/custom.js','js/bootstrap-wysihtml5.js','plugins/fileinput/js/fileinput.min.js','js/bootstrap-timepicker.min.js','js/select2.min.js'),
                    ),

                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'page_title' => 'Users',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Users',
                ),
                'actions' => array(
                    'appendJs' => array(
                        'src' => array('media/picturecut/jquery.picture.cut.js','plugins/autocomplete/jquery.autocomplete.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','plugins/switch/css/bootstrap3/bootstrap-switch.min.css','css/bootstrap-wysihtml5.css','plugins/fileinput/css/fileinput.min.css','css/bootstrap-timepicker.min.css','plugins/autocomplete/jquery.autocomplete.css')
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'users_edit_wrapper' => array(
                        'type' => 'Store/Users/Edit',
                        'template' => 'store/users/edit',
                        'children' => array(
                            'general' => array(
								'type' => 'Store/Users/Edit',
                                'template' => 'store/users/general',
								'children' => array(
									'doctor_edit' => array(
										'type' => 'Store/Users/Edit',
										'template' => 'store/users/doctoredit',
										 'children' => array(
												'countrycityarea' => array(
													'type' => 'Store/Clinic/Countrycityarea',
													'template' => 'store/clinic/countrycityarea',
												),
										 ),
								),
								'gallery' => array(
									'type' => 'Store/Common/Gallery',
									'template' => 'common/gallery',
								),
                                'videos' => array(
									'type' => 'Store/Common/Videos',
									'template' => 'common/videos',
								),
								'schedule' => array(
									'type' => 'Store/Users/Schedule',
									'template' => 'store/users/schedule',
								),
                                ),
                            ),  
                            'admin_edit' => array(
								'type' => 'Store/Users/Edit',
                                'template' => 'store/users/adminedit',
                                'children' => array(
										'countrycityarea' => array(
											'type' => 'Store/Clinic/Countrycityarea',
											'template' => 'store/clinic/countrycityarea',
										),
								 ),
                            ),  
                        ),
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'home',
                            'crumbinfo' => array('link' => 'dashboard/index','label' => __('Home'),'title' => __('Home')),
                        ),

                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'users',
                            'crumbinfo' => array('link' => 'users/index','label' => __('Doctors'),'title' => __('Doctors')),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'store/users/editprofile' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'users/user',
                ),
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('plugins/switch/js/bootstrap-switch.min.js','js/jquery-ui-1.10.3.min.js','js/custom.js'),
                    ),

                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'page_title' => 'Users',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Users',
                ),
                'actions' => array(
                    'appendJs' => array(
                        'src' => array('media/picturecut/jquery.picture.cut.js','pinmap.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','plugins/switch/css/bootstrap3/bootstrap-switch.min.css')
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'users_edit_wrapper' => array(
                        'type' => 'Store/Users/Edit',
                        'template' => 'store/users/adminedit',
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'home',
                            'crumbinfo' => array('link' => 'dashboard/index','label' => __('Home'),'title' => __('Home')),
                        ),

                    ), 
                ),
            ),
        ),
    ),

    
    'admin/users/userlist' => array(
        'content' => array(
            'type' => 'Admin/Users/Search/Users',
            'template' => 'admin/users/search/userslist',
        )
    ),
    'admin/users/loadactivityajax' => array(
        'content' => array(
            'type' => 'Admin/Users/View',
            'template' => 'admin/users/view/activitys'
        ),
    ),
    'store/users/ajaxlist' => array(
        'content' => array(
            'children' => array(
                'listing' => array(
                    'type' => 'Store/Users/List',
                ),
            ),
        )
    ),   
    'store/users/exportexcel' => array(
        'content' => array(
            'children' => array(
                'userslist' => array(
                    'type' => 'Store/Users/Export',
                ),
            ),
        )
    ),   
);
