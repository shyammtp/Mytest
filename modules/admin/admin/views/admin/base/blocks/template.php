<?php
$blockname = 'email_template';
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
    'admin/template/email' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/notificationtemplates',
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
                    'title_icon' => '<i class="fa fa-envelope-o" ></i>&nbsp;',
                    'page_title' => 'Notification Template',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Notification Template',
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/Template/Email/Manage',
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
                            'crumbinfo' => array('label' => __('Notification Template'),'title' => __('Notification Template')),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'admin/template/edit' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/notificationtemplates',
                ),
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/custom.js','plugins/tinymce4.1/tinymce.min.js'),
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'title_icon' => '<i class="fa fa-envelope-o" ></i>&nbsp;',
                    'page_title' => 'Notification Template',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Notification Template',
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/Template/Email/Edit',
                        'template' => 'template/email/edit'
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
                            'crumbinfo' => array('label' => __('Notification Template'),'title' => __('Notification Template')),
                        ),
                    ),
                ),
            ),
        ),
    ), 
    'admin/template/view' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/notificationtemplates',
                ),
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/custom.js','plugins/tinymce4.1/tinymce.min.js'),
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'page_title' => 'Notification Template',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Notification Template',
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/Template/Email/Edit',
                        'template' => 'template/email/view'
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
                            'crumbinfo' => array('label' => __('Notification Template'),'title' => __('Notification Template')),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'admin/template/ajaxtemplatelist' => array(
        'content' => array(
            'children' => array(
                'listing' => array(
                    'type' => 'Admin/Template/Email/Manage',
                ),
            ),
        )
    ),   
    
);
