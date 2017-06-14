<?php
$blockname = 'category';
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
    'admin/category/categories' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'place/placecategory',
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
                    'page_title' => 'Place Category',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Place Category',
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'listing' => array(
						'type' =>'Admin/Category/Managecategory',
					),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'place_category',
                            'crumbinfo' => array('link'=>'admin/category/categories','label' => 'Place Category','title' => 'Place Category'),
                        ),

                    ),
                ),
            ),
        ),
    ),
    'admin/category/editcategory' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'place/placecategory',
                ),
            ),
            'bottomincludes' => array(
				'actions' => array(
					'appendJs' => array(
								'src' => array('media/picturecut/jquery.picture.cut.js','pinmap.js'),
					 ),
					'appendThemeJs' => array(
						'src' => array('js/jquery.tagsinput.min.js','plugins/switch/js/bootstrap-switch.min.js','js/jquery-ui-1.10.3.min.js','js/custom.js'),
					),
				),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'title_icon' => '<i class="fa  fa-sitemap" ></i>&nbsp;',
                    'page_title' => 'Place Category',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Place Category',
                ),
                'actions' => array(
                    'appendThemeCss' => array(
                        'src' => array('css/jquery.tagsinput.css','css/jquery-ui-1.10.3.css','plugins/switch/css/bootstrap3/bootstrap-switch.min.css'),
                    ),
                ),
            ),

            'maincontent' => array(
                'children' => array(
                    'category_edit' => array(
                        'type' => 'Admin/Category/Category',
                        'template' => 'category/edit',
                          'children' => array(
							'form' => array(
								'type' => 'Admin/Category/Category',
								'template' => 'category/edit/form',
							),

						),
                    ),

                ),
            ),

            'breadcrumbs' => array(
                'actions' => array(
					'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'Place Category',
                            'crumbinfo' => array('label' => 'Place Category','title' => 'Place Category','link'=>'admin/category/categories'),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'admin/category/editcategoryform' => array(
			'content' => array(
				'type' => 'Admin/Category/Category',
				'template' => 'category/popup',
				'children' => array(
						'form' => array(
							 'type' => 'Admin/Category/Category',
							'template' => 'category/edit/form',
						),
				),
			),
    ),
    'admin/category/editsubcategoryform' => array(
        'content' => array(
            'type' => 'Admin/Category/Category',
              'template' => 'category/popup1',
				'children' => array(
					'form' => array(
						'type' => 'Admin/Category/Category',
						'template' => 'category/edit/form1',
					),
			),
        ),
    ),
    'admin/category/ajaxcategories' => array(
        'content' => array(
            'children' => array(
                'listing' => array(
                    'type' => 'Admin/Category/Managecategory',
                ),
            ),
        )
    ),   

);
