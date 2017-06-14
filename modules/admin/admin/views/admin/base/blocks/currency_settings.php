<?php
$blockname = 'currency_settings';
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
    'admin/settings/currency_settings' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/currency_settings',
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
                    'page_title' => 'Currency Settings',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Currency Settings',
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/Currency/Manage',
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
                            'crumbinfo' => array('label' => __('Currency Settings'),'title' => __('Currency Settings')),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    'admin/settings/edit_currency' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'settings/currency_settings',
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
                    'page_title' => 'Currency Settings',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Currency Settings',
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/Currency/Edit',
                        'template' => 'currency/edit'
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
                            'crumbinfo' => array('label' => __('Currency Settings'),'title' => __('Currency Settings')),
                        ),
                    ),
                ),
            ),
        ),
    ), 
);
