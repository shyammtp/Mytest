<?php
$blockname = 'email_subject';
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
    'admin/settings/email_subject' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/email_subject',
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
                    'page_title' => 'Email Subject',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Notification Subject',
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/Email/Manage',
					),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(                     
                    'action3' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'layouts',
                            'crumbinfo' => array('label' => 'Notification Subject','title' => 'Notification Subject'),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'admin/settings/edit_email_subject' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/email_subject',
                ),
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/wysihtml5-0.3.0.min.js','js/bootstrap-wysihtml5.js','plugins/switch/js/bootstrap-switch.min.js','js/jquery-ui-1.10.3.min.js','js/custom.js','js/brand.js','plugins/checboxtree/jquery.checkboxtree.min.js','plugins/autocomplete/jquery.autocomplete.js','js/colorpicker.js'),
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'page_title' => 'Notification Subject',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Notification Subject',
                ),
                'actions' => array(
                    'appendThemeCss' => array(
                                  'src' => array('css/jquery-ui-1.10.3.css','css/bootstrap-wysihtml5.css','plugins/switch/css/bootstrap3/bootstrap-switch.min.css','plugins/checboxtree/jquery.checkboxtree.min.css','plugins/autocomplete/jquery.autocomplete.css','css/colorpicker.css'),
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/Email/Edit',
                        'template' => 'email/edit'
					),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(                    
                    'action3' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'layouts',
                            'crumbinfo' => array('link' => 'admin/settings/email_subject','label' => 'Notification Subject','title' => 'Notification Subject'),
                        ),
                    ),                    
                ),
            ),
        ),
    ), 
    'admin/settings/emailajaxlist' => array(	
        'content' => array(
            'children' => array(
                'listing' => array(
                    'type' => 'Admin/Email/Manage',
                ),
            ),
        )
    ),  
);
