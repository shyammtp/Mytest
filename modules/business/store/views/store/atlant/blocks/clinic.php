<?php
$blockname = 'clinic';
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
    'store/clinic/index' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'medical_places',
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
                    'page_title' => 'Clinic',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Clinic',
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'cliniclisting' => array(
						'type' => 'Store/Clinic/List',
					),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                     
                ),
            ),
        ),
    ),
    'store/clinic/editclinic' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'medical_places',
                ),
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendJs' => array(
                        'src' => array('jquery.validate.min.js'),
                    ),
                    'appendThemeJs' => array(
                       'src' => array('plugins/switch/js/bootstrap-switch.min.js','plugins/autocomplete/jquery.autocomplete.js','js/jquery-ui-1.10.3.min.js','js/custom.js', 'plugins/fileinput/js/fileinput.min.js','js/bootstrap-timepicker.min.js','js/select2.min.js','js/jquery.tagsinput.min.js'),
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'page_title' => 'Clinic Edit',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Clinic Edit',
                ),
                'actions' => array(
					'appendJs' => array(
                        'src' => array('media/picturecut/jquery.picture.cut.js','plugins/autocomplete/jquery.autocomplete.js'),
                    ),
                    'appendThemeCss' => array(
                                  'src' => array('css/jquery-ui-1.10.3.css','plugins/switch/css/bootstrap3/bootstrap-switch.min.css','plugins/fileinput/css/fileinput.min.css','css/bootstrap-timepicker.min.css','plugins/autocomplete/jquery.autocomplete.css','css/jquery.tagsinput.css')
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'general' => array(
						'type' => 'Store/Clinic/Edit',
						'template' => 'store/clinic/general',
							'children' => array(
								'clinicedit' => array(
									'type' => 'Store/Clinic/Edit',
									'template' => 'store/clinic/edit',
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
									'type' => 'Store/Clinic/Schedule',
									'template' => 'store/clinic/schedule',
								),
								
						 ),
                        
                    ),

                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
					 
                ),
            ),
        ),
    ),
    'store/clinic/ajaxclinic' => array(
        'content' => array(
            'children' => array(
                'cliniclist' => array(
                    'type' => 'Store/Clinic/List',
                ),
            ),
        )
    ),  
    'store/clinic/exportexcel' => array(
        'content' => array(
            'children' => array(
                'cliniclist' => array(
                    'type' => 'Store/Clinic/Export',
                ),
            ),
        ),
    ),  
    'store/clinic/getcity' => array(
        'content' => array(
            'children' => array(
                'city' => array(
                     'type' => 'Store/Area/Edit',
                     'template' => 'store/clinic/city'
                ),
            ),           
        ),
    ),     
    'store/clinic/getarea' => array(
        'content' => array(
            'children' => array(
                'area' => array(
                     'type' => 'Store/Area/Edit',
                     'template' => 'store/clinic/area'
                ),
            ),           
        ),
    ),   
);
