<?php
$blockname = 'url_rewrite';
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
    'domain/list/urlrewrite' => array(
    'reference' => array(
        'leftmenu' => array( 
            'attributes' => array(
                'active' => 'url_rewrite',  
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
                'page_title' => 'URL Rewrite Management',
            ),
        ),
        'head' => array( 
            'attributes' => array(
                'title' => 'URL Rewrite Management',  
            ),
        ), 
         'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/Url/List',
					),
                ),
            ),
        'breadcrumbs' => array( 
            'actions' => array( 
                'action0' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'urlrewrite',
                        'crumbinfo' => array('label' => 'URL Rewrite','title' => 'URL Rewrite'),
                    ),
                     
                ),  
            ),
        ), 
    ),
    ),
    'domain/list/edit_url' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'url_rewrite',
                ),
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendJs' => array(
                        'src' => array('jquery.validate.min.js'),
                    ),
                    'appendThemeJs' => array(
                        'src' => array('plugins/switch/js/bootstrap-switch.min.js','js/custom.js'),
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'page_title' => 'URL Rewrite',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'URL Rewrite',
                ),
                'actions' => array(
                    'appendThemeCss' => array(
                        'src' => array('plugins/switch/css/bootstrap3/bootstrap-switch.min.css'),
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'url_edit' => array(
                        'type' => 'Admin/Url/Edit',
                        'template' => 'domain/url/edit',
                    ),

                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
					'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'education',
                            'crumbinfo' => array('link' => 'domain/list/urlrewrite','label' => 'URL Rewrite','title' => 'URL Rewrite'),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'domain/list/ajaxload' => array(
        'content' => array(
            'children' => array(
                'urlrewritelist' => array(
                    'type' => 'Admin/Url/List',
                ),
            ),
        )
    ) 
);
