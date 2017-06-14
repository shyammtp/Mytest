<?php 
$blockname = 'subrolesuser';
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
                'active' => 'permissions/users',
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
                'page_title' => 'Roles User Management',
            ),
        ),
        'head' => array(
            'attributes' => array(
                'title' => 'Roles/ Permission / System - Admin',
            ),
            'actions' => array(
                'appendThemeCss' => array(
                    'src' => array('css/colorpicker.css'),
                ),
            ),
        ),
        'maincontent' => array(
            'children' => array(
                'roles_list_grid' => array(
                    'type' => 'Admin/System/Permission/Users/Subrolesusers',
                ),
            ),
        ),
        'breadcrumbs' => array(
            'actions' => array(
                'action1' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'permission_roles',
                        'crumbinfo' => array('link' => 'admin/system_permission_users/index','label' => __('Permission'),'title' => __('Permission')),
                    ),

                ),
                'action2' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'roles',
                        'crumbinfo' => array('label' => __('Roles'),'title' => __('Roles')),
                    ),

                ),
            ),
        ),
    ),
);
