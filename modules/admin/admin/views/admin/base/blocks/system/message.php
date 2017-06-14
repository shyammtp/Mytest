<?php 
$blockname = 'message';
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
                'active' => 'messages',
            ),
        ),
        'bottomincludes' => array(
            'actions' => array(
               'appendThemeJs' => array(
                    'src' => array('js/colorpicker.js','js/custom.js'),
                ),
            ),
        ),
        'content' => array(
            'attributes' => array(
                'body_class'  => $blockname.'_class page-header-fixed',
                'page_title' => 'Message Management',
            ),
        ),
        'head' => array(
            'attributes' => array(
                'title' => 'Message / System - Admin',
            ),
            'actions' => array(
                'appendThemeJs' => array(
                    'src' => array('js/jquery-ui-1.10.3.min.js','plugins/tinymce4.1/tinymce.min.js','js/jquery.validate.min.js'),
                ),
                'appendThemeCss' => array(
                    'src' => array('css/jquery-ui-1.10.3.css'),
                ),
            ),
        ),        
        'maincontent' => array(
                'children' => array(
                    'message_edit' => array(
                        'type' => 'Admin/System/Edit',
                        'template' => 'system/message',
                    ),

                ),
         ),
        'breadcrumbs' => array(
            'actions' => array(
                'action0' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'system',
                        'crumbinfo' => array('link' => 'admin/system/cache.do','label' => 'System','title' => 'System'),
                    ),
                ),               
                'action1' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'message',
                        'crumbinfo' => array('label' => __('Message'),'title' => __('Message')),
                    ),
                ),
            ),
        ),
    ),
     'admin/system/inbox' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'messages/inbox',
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
                    'page_title' => 'Message',
                ),
            ),
            'head' => array(
				'attributes' => array(
					'title' => 'Message / System - Admin',
				),
				'actions' => array(
					'appendThemeJs' => array(
						'src' => array('js/jquery-ui-1.10.3.min.js','plugins/tinymce4.1/tinymce.min.js','js/jquery.validate.min.js'),
						
					),
					'appendThemeCss' => array(
						'src' => array('css/jquery-ui-1.10.3.css'),
					),
				),
			),
			'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/System/List',
					),
                ),
            ),
            'breadcrumbs' => array(
            'actions' => array(                            
                'action1' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'message',
                        'crumbinfo' => array('label' => __('Message'),'title' => __('Message')),
                    ),

                ),
            ),
		),
           
        ),
    ),
    'admin/system/sendmessages' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'messages/sendmessages',
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
                    'page_title' => 'Message',
                ),
            ),
            'head' => array(
            'attributes' => array(
                'title' => 'Message / System - Admin',
            ),
            'actions' => array(
                'appendThemeCss' => array(
                    'src' => array('css/jquery-ui-1.10.3.css'),
                ),
            ),
        ),
            'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/System/Sendmessages/List',
					),
                ),
            ),
            'breadcrumbs' => array(
            'actions' => array(            
                'action1' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'message',
                        'crumbinfo' => array('label' => __('Message'),'title' => __('Message')),
                    ),

                ),
            ),
        ),
            
           
        ),
    ),
    'admin/system/reply_message' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'messages',
                ),
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendJs' => array(
                        'src' => array('jquery.validate.min.js','moment.js'),
                    ),
                    'appendThemeJs' => array(
						'src' => array('plugins/switch/js/bootstrap-switch.min.js','js/jquery-ui-1.10.3.min.js','js/custom.js','js/bizbox.js'),
					),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'page_title' => 'Message',
                ),
            ),
            'head' => array(
				'attributes' => array(
					'title' => 'Messge / System - Admin',
				),
				'actions' => array(
					'appendThemeJs' => array(
						'src' => array('js/jquery-ui-1.10.3.min.js','plugins/tinymce4.1/tinymce.min.js','js/jquery.validate.min.js'),
					),
					'appendThemeCss' => array(
						'src' => array('css/jquery-ui-1.10.3.css'),
					),
				),
			), 
            'maincontent' => array(
                'children' => array(
                    'message_reply' => array(
                        'type' => 'Admin/System/Edit',
                        'template' => 'system/message/reply',
                    ),

                ),
			),			            
        ),
    ),
    'admin/system/sendmessagesajaxlist' => array(
        'content' => array(
            'children' => array(
                'listing' => array(
                    'type' => 'Admin/System/Sendmessages/List',
                ),
            ),
        ),
    ),    
    'admin/system/inboxajax' => array(
        'content' => array(
            'children' => array(
                'inbox_list' => array(
                    'type' => 'Admin/System/List',
                ),
            ),
        )
    ) 
);

