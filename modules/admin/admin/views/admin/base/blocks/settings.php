<?php
$blockname = 'general';
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
    'admin/settings/general' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/general',
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
                        'type' => 'Admin/Page/Js',
                        'template' => 'settings/general/js',
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'title_icon' => '<i class="fa fa-cog" ></i>&nbsp;',
                    'page_title' => 'General Settings',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'General / Settings - Admin',
                ),
                'actions' => array(
                   'appendThemeCss' => array(
                        'src' => array('css/select2.css'),
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'general_forms' => array(
                        'type' => 'Configuration/Elements',
                        'template' => 'configuration/elements',
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'settings',
                            'crumbinfo' => array('link' => 'admin/settings/general','label' => __('Settings'),'title' => __('Settings')),
                        ),

                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'general',
                            'crumbinfo' => array('label' => 'General','title' => 'General'),
                        ),

                    ),
                ),
            ),
        ),
    ),
    'admin/settings/email' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/email',
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
                        'type' => 'Admin/Page/Js',
                        'template' => 'settings/general/js',
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'title_icon' => '<i class="fa fa-envelope" ></i>&nbsp;',
                    'page_title' => 'Email SMTP Settings',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Email / Settings - Admin',
                ),
                'actions' => array(
                   'appendThemeCss' => array(
                        'src' => array('css/select2.css'),
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'email_forms' => array(
                        'type' => 'Configuration/Elements',
                        'template' => 'configuration/elements',
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'settings',
                            'crumbinfo' => array('link' => 'admin/settings/general','label' => __('Settings'),'title' => __('Settings')),
                        ),

                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'email',
                            'crumbinfo' => array('label' => 'Email','title' => 'Email'),
                        ),

                    ),
                ),
            ),
        ),
    ),
    'admin/settings/product' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/products_settings',
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
                    'title_icon' => '<i class="fa fa-pied-piper-square" ></i>&nbsp;',
                    'page_title' => 'Product Settings',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Product / Settings - Admin',
                ),
                'actions' => array(
                   'appendThemeCss' => array(
                        'src' => array('css/select2.css'),
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'product_forms' => array(
                        'type' => 'Configuration/Elements',
                        'template' => 'configuration/elements',
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'settings',
                            'crumbinfo' => array('link' => 'admin/settings/general','label' => __('Settings'),'title' => __('Settings')),
                        ),

                    ),                    
                ),
            ),
        ),
    ),
    'admin/settings/users_templates' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/users/users_template',
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
                        'type' => 'Admin/Page/Js',
                        'template' => 'settings/general/js',
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'title_icon' => '<i class="fa fa-user" ></i>&nbsp;',
                    'page_title' => 'User Email Templates',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'User Email Templates / Settings - Admin',
                ),
                'actions' => array(
                   'appendThemeCss' => array(
                        'src' => array('css/select2.css'),
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'users_template_forms' => array(
                        'type' => 'Configuration/Elements',
                        'template' => 'configuration/elements',
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'settings',
                            'crumbinfo' => array('link' => 'admin/settings/general','label' => __('Settings'),'title' => __('Settings')),
                        ),

                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'email',
                            'crumbinfo' => array('label' => __('Email Templates'),'title' => __('Email Templates')),
                        ),

                    ),
                ),
            ),
        ),
    ),
    'admin/settings/users_settings' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/users/users_settings',
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
                        'type' => 'Admin/Page/Js',
                        'template' => 'settings/general/js',
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'title_icon' => '<i class="fa fa-envelope" ></i>&nbsp;',
                    'page_title' => 'User Settings',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'User / Settings - Admin',
                ),
                'actions' => array(
                   'appendThemeCss' => array(
                        'src' => array('css/select2.css'),
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'users_settings' => array(
                        'type' => 'Configuration/Elements',
                        'template' => 'configuration/elements',
                    ),

                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'settings',
                            'crumbinfo' => array('link' => 'admin/settings/general','label' => __('Settings'),'title' => __('Settings')),
                        ),

                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'email',
                            'crumbinfo' => array('label' => __('User Settings'),'title' => __('User Settings')),
                        ),

                    ),
                ),
            ),
        ),
    ),
    'admin/settings/social_media' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/social_media',
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
                        'type' => 'Admin/Page/Js',
                        'template' => 'settings/general/js',
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'title_icon' => '<i class="fa fa-globe" ></i>&nbsp;',
                    'page_title' => 'Social Media Settings',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Social Media / Settings - Admin',
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
                        'type' => 'Configuration/Elements',
                        'template' => 'configuration/elements',
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'settings',
                            'crumbinfo' => array('link' => 'admin/settings/general','label' => __('Settings'),'title' => __('Settings')),
                        ),

                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'social',
                            'crumbinfo' => array('label' => __('Social Media'),'title' => __('Social Media')),
                        ),

                    ),
                ),
            ),
        ),
    ),
    'admin/settings/cache' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/cache',
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
                        'type' => 'Admin/Page/Js',
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
                        'type' => 'Admin/Settings/Cache',
                        'template' => 'settings/cache',
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'settings',
                            'crumbinfo' => array('link' => 'admin/settings/general','label' => __('Settings'),'title' => __('Settings')),
                        ),

                    ),
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
    'admin/settings/exchangeratetable' => array(
        'content' => array(
            'children' => array(
                'exchangetable' => array( 
                    'type' => 'Admin/Settings/Exchangetable',
                )
            ),
        )
    ),
);
