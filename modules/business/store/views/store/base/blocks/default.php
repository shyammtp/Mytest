<?php
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
 */

return array(
    'content' => array(
        'type'  => 'Store/Page',
        'template' => 'column/2column-left',
        'children'  => array(
            'head' => array(
                'type' => 'Store/Page/Head',
                'template' => 'page/head',
            ),
            'header' => array(
                'type' => 'Store/Page/Header',
                'template' => 'page/header',
            ),
            'bottomincludes' => array(
                'type' => 'Store/Page/Js',
                'template' => 'page/js',
            ),
            'leftmenu' => array(
                'type' => 'Store/Page/Sidebar',
                'template' => 'page/sidebar',
            ),
            'maincontent' => array(
                'type' => 'Store/Page/Wrapper',
                'template' => 'page/wrapper',
            ),
            'noticemessages' => array(
                'type' => 'Core/Notice',
            ),
            'breadcrumbs' => array (
                'type' => 'Store/Breadcrumb',
                'template' => 'page/breadcrumbs',
                'actions' => array(
                    'homeaction1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'home',
                            'crumbinfo' => array('link' => 'admin/dashboard/index','label' => __('Home'),'title' => __('Home')),
                        ),

                    ),
                ),

            ),
            'footer' => array(
                'type' => 'Store/Page/Footer',
                'template' => 'page/footer',
            ),
        ),
    ),
);
