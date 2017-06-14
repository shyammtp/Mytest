<?php
$blockname = 'merchant';
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
	'admin/merchant/index' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'merchants',
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
                        'type' => 'Admin/Page',
                        'template' => 'admin/users',
                        'children' => array(
                            'user_listing' => array(
                                'type' => 'Admin/Merchant/List',
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
                            'crumbinfo' => array('link' => 'admin/dashboard/index','label' => __('Home'),'title' => __('Home')),
                        ),

                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'users',
                            'crumbinfo' => array('label' => 'Users','title' => 'Users'),
                        ),

                    ),
                ),
            ),
        ),
    ),
     'admin/merchant/edit' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'merchants',
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
                    'users_view' => array(
                        'type' => 'Admin/Merchant/Edit',
                        'template' => 'admin/merchant/edit', 
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'home',
                            'crumbinfo' => array('link' => 'admin/dashboard/index','label' => __('Home'),'title' => __('Home')),
                        ),

                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'users',
                            'crumbinfo' => array('label' => 'Users','title' => 'Users'),
                        ),

                    ),
                ),
            ),
        ),
    ),
     'admin/merchant/view' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'merchants',
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
                    'users_view' => array(
                        'type' => 'Admin/Merchant/View',
                        'template' => 'admin/merchant/view', 
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'home',
                            'crumbinfo' => array('link' => 'admin/dashboard/index','label' => __('Home'),'title' => __('Home')),
                        ),

                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'users',
                            'crumbinfo' => array('label' => 'Users','title' => 'Users'),
                        ),

                    ),
                ),
            ),
        ),
    ),
     
);
