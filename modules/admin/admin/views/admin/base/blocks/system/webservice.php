<?php
$blockname = 'cache';
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
    'admin/system_webservice/index' => array(
        'reference' => array(
            'leftmenu' => array( 
                'attributes' => array(
                    'active' => 'webservice/apiresources',  
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
                    'title_icon' => '<i class="fa fa-globe" ></i>&nbsp;',
                    'page_title' => 'Webservice Management',
                ),
            ),
            'head' => array( 
                'attributes' => array(
                    'title' => 'API Resource / Webservice / System - Admin',  
                ), 
            ), 
            'maincontent' => array( 
                'children' => array(
                    'webservice_grid_list' => array(
                        'type' => 'Admin/System/Webservice/List'
                    ),
                ),
            ), 
            'breadcrumbs' => array( 
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'system',
                            'crumbinfo' => array('link' => 'admin/system_webservice/index','label' => __('System'),'title' => __('System')),
                        ),
                         
                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'webservice',
                            'crumbinfo' => array('label' => __('Webservice'),'title' => __('Webservice')),
                        ),
                         
                    ),
                ),
            ), 
        ),
    ),
    
    'admin/system_webservice/edit' => array(
        'reference' => array(
            'leftmenu' => array( 
                'attributes' => array(
                   'active' => 'webservice/apiresources',  
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
                    'title_icon' => '<i class="fa fa-globe" ></i>&nbsp;',
                    'page_title' => 'Webservice Management',
                ),
            ),
            'head' => array( 
                'attributes' => array(
                    'title' => 'Edit - API Resource / Webservice / System - Admin',  
                ), 
            ), 
            'maincontent' => array( 
                'children' => array(
                    'webservice_edit' => array(
                        'type' => 'Admin/System/Webservice/Edit',
                        'template' => 'system/webservice/edit'
                    ),
                ),
            ), 
            'breadcrumbs' => array( 
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'system',
                            'crumbinfo' => array('link' => 'admin/system_webservice/index','label' => __('System'),'title' => __('System')),
                        ),
                         
                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'webservice',
                            'crumbinfo' => array('label' => __('Webservice'),'title' => __('Webservice')),
                        ),
                         
                    ),
                ),
            ), 
        ),
    ),
);
