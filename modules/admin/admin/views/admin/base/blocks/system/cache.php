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
    'reference' => array(
        'leftmenu' => array( 
            'attributes' => array(
                'active' => 'system/cache',  
            ),
        ),
        'bottomincludes' => array(   
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
                'page_title' => 'Cache Management',
            ),
        ),
        'head' => array( 
            'attributes' => array(
                'title' => 'Cache / System - Admin',  
            ),
            'actions' => array(
               'appendCss' => array(
                    'src' => array('plugins/ios-switch/ios7-switch.css'),
                ),
               'appendJs' => array(
                    'src' => array('js/widget/list.js'),
                ),
            ),
        ), 
        'maincontent' => array(
            'actions' => array(
                'setTemplate' => array(
                    'template' => 'system/cache',
                ),
            ),
            'children' => array(
                'cache_grid_list' => array(
                    'type' => 'Admin/System/Cache/List'
                ),
            ),
        ), 
        'breadcrumbs' => array( 
            'actions' => array(
                'action1' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'system',
                        'crumbinfo' => array('link' => 'admin/system/cache.do','label' => 'System','title' => 'System'),
                    ),
                     
                ),
                'action2' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'cache',
                        'crumbinfo' => array('label' => 'Cache','title' => 'Cache'),
                    ),
                     
                ),
            ),
        ), 
    ),
);