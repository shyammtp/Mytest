<?php
$blockname = 'dashboard';
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
    'reference' => array(
        'leftmenu' => array(
            'attributes' => array(
                'active' => 'dashboard',
            ),
        ),
		'bottomincludes' => array(
			'actions' => array(
				'appendThemeJs' => array(
					'src' => array('js/jquery-ui-1.10.3.min.js','js/custom.js','plugins/autocomplete/jquery.autocomplete.js','js/bizbox.js','plugins/timepicker/moment.js','plugins/timepicker/bootstrap-datetimepicker.min.js'),
				),
			),
		),
        'content' => array(
            'attributes' => array(
                'body_class'  => $blockname.'_class page-header-fixed',
                'page_title' => 'Admin Bizbox',
            ),
        ),
        'head' => array(
            'attributes' => array(
                'title' => 'Admin Bizbox',
            ),
			'actions' => array(
				'appendThemeCss' => array(
				'src' => array('css/jquery-ui-1.10.3.css','plugins/timepicker/css/bootstrap-datetimepicker.min.css')
				),
			),
        ),
       'maincontent' => array(
                'children' => array(
                    'dashboard' => array(
                        'type' => 'Store/Dashboard',
                        'template' => 'dashboard/index',
                    ),

                ),
         ),
        'breadcrumbs' => array(
            'actions' => array(
                'action2' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'layout',
                        'crumbinfo' => array('label' => __('Dashboard'),'title' => __('Dashboard')),
                    ),

                ),
            ),
        ),
    ),
    
    'store/dashboard/import' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'import',
                ),
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/custom.js'),
                    ),
                ),
                'children' => array(
                    'dashboardjs' => array(
                        'type' => 'Store/Page/Js',
                        'template' => 'settings/general/js',
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'title_icon' => '<i class="fa fa-upload" ></i>&nbsp;',
                    'page_title' => 'Import',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Import',
                ),
                'actions' => array(
                   'appendThemeCss' => array(
                        'src' => array('css/select2.css'),
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'social_media_forms' => array(
                        'type' => 'Store/Import',
                        'template' => 'dashboard/import',
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'import',
                            'crumbinfo' => array('label' => __('Import'),'title' => __('Import')),
                        ),

                    ),
                ),
            ),
        ),
    ),
);
