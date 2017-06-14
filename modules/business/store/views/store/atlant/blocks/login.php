<?php
$blockname = 'store_login';
/*
 * array starting index will be used on rendered to the controller. In here "content" is first index.
 *
 * Eg: $block->getBlock('content');
 *
 *
 * indexes,
 * - type (Required) = will be the block class which needs to be in classes/Blocks folder.
 *       For eg: classes/Blocks/Front/Template.php define as "Front/Template"
 * - template (optional) - If doesnt defined here need to define in the constructor of the block class.
 * - Children (optional) -  Children will be used to access the block and template inside another block.
 * - attributes (optional) - Values can get into the template file or block file using setter and getter method.
 */

return array(
    'reference' => array(
        'bottomincludes' => array(
        ),
        'content' => array(
            'attributes' => array(
                'body_class'  => $blockname.'_class login page-header-fixed',
                'page_title' => 'Admin Dashboard',

            ),
            'actions' => array(
                'setTemplate' => array(
                    'template' => 'column/1column',
                ),
            ),
        ),
        'head' => array(
            'attributes' => array(
                'title' => 'Insurance Login',
            ),

        ),
        'maincontent' => array( 
            'children' => array(
                'loginform' => array(
                    'type' => 'Store/Login',
                    'template' => 'login/login',
                )
            )
        ),
        'breadcrumbs' => array(
            'actions' => array(
                'action1' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'home',
                        'crumbinfo' => array('link' => 'index','label' => __('Home'),'title' => __('Home')),
                    ),

                ),
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
);
