<?php
$blockname = 'permission_users';
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
                'active' => 'permission/users',
            ),
        ),
        'bottomincludes' => array(
            'actions' => array(
                'appendThemeJs' => array(
                    'src' => array('js/jquery-ui-1.10.3.min.js','js/custom.js'),
                ),
            ),
        ),
        'content' => array(
            'attributes' => array(
                'body_class'  => $blockname.'_class page-header-fixed',
                'page_title' => 'Roles Users Management',
            ),
        ),
        'head' => array(
            'attributes' => array(
                'title' => 'Users / Permission / System - Admin',
            ),
            'actions' => array(
                'appendThemeCss' => array(
                    'src' => array('css/jquery-ui-1.10.3.css'),
                ),
            ),
        ),
        'maincontent' => array(
            'children' => array(
                'edituser' => array(
                    'type' => 'Admin/System/Permission/Users/Edit',
                    'template' => 'system/permissions/users/edit',
                        'children' => array(
                              'edit_users_list_grid' => array(
                              'type' => 'Admin/System/Permission/Users/Edit',
                              'template' => 'system/permissions/users/edit/roles_users'
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
                        'crumbname' => 'permission_roles',
                        'crumbinfo' => array('link' => 'admin/system_permission_roles/index','label' => __('Permission'),'title' => __('Permission')),
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
