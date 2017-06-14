<?php
$blockname = 'language_settings';
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
    'admin/settings/language_settings' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/language_settings',
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
                    'page_title' => 'Language Settings',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Language Settings',
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/Language/Manage',
					),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array( 
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'layout',
                            'crumbinfo' => array('label' => __('Settings'),'title' => __('Settings')),
                        ),
                    ),
                    'action3' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'layout',
                            'crumbinfo' => array('label' => 'Language Settings','title' => 'Language Settings'),
                        ),
                    ),
                ),
            ),
        ),
     ),
     'admin/settings/edit_language' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/language_settings',
                ),
            ),
             'bottomincludes' => array(
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/jquery.tagsinput.min.js','js/jquery-ui-1.10.3.min.js','plugins/switch/js/bootstrap-switch.min.js','js/wysihtml5-0.3.0.min.js','js/bootstrap-wysihtml5.js','plugins/fileinput/js/fileinput.min.js','js/bootstrap-wizard.min.js','js/custom.js'),
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'page_title' => 'Language Settings',
                ),
            ),
          'head' => array(
                'attributes' => array(
                    'title' => 'Language Settings',
                ),
                'actions' => array(
                    'appendThemeCss' => array(
                        'src' => array('css/jquery.tagsinput.css','css/jquery-ui-1.10.3.css','plugins/switch/css/bootstrap3/bootstrap-switch.min.css','css/bootstrap-wysihtml5.css','plugins/fileinput/css/fileinput.min.css'),
                    ),
  
                'appendJs' => array(
                        'src' => array('jquery.validate.min.js','pinmap.js'),
                    ),
                 ),
            ),
            'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/Language/Edit',
                        'template' => 'language/edit'
					),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array( 
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'layout',
                            'crumbinfo' => array('label' => __('Settings'),'title' => __('Settings')),
                        ),
                    ),
                    'action3' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'layout',
                             'crumbinfo' => array('link' => 'admin/settings/language_settings','label' => 'Language Settings','title' => 'Language Settings'),
                            //'crumbinfo' => array('label' => 'Language Settings','title' => 'Language Settings'),
                        ),
                    ),
                ),
            ),
        ),
    ), 
);
           
