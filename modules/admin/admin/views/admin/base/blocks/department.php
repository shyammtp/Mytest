<?php
$blockname = 'department';
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
    'admin/department/index' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'department/department',
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
                    'page_title' => 'Department',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Department',
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'departmentlisting' => array(
						'type' => 'Admin/Department/List',
					),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'Department',
                            'crumbinfo' => array('label' => __('Department'),'title' => __('Department')),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'admin/department/editdepartment' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'department/department',
                ),
            ),
            'bottomincludes' => array(
                'actions' => array(
                    'appendJs' => array(
                        'src' => array('jquery.validate.min.js'),
                    ),
                    'appendThemeJs' => array(
                        'src' => array('js/wysihtml5-0.3.0.min.js','js/bootstrap-wysihtml5.js','plugins/switch/js/bootstrap-switch.min.js','js/jquery-ui-1.10.3.min.js','js/custom.js','js/brand.js','plugins/checboxtree/jquery.checkboxtree.min.js','plugins/autocomplete/jquery.autocomplete.js'),
                    ),
                ),
            ),
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'page_title' => 'Department Edit',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Department Edit',
                ),
                'actions' => array(
                    'appendThemeCss' => array(
                                  'src' => array('css/jquery-ui-1.10.3.css','css/bootstrap-wysihtml5.css','plugins/switch/css/bootstrap3/bootstrap-switch.min.css','plugins/checboxtree/jquery.checkboxtree.min.css','plugins/autocomplete/jquery.autocomplete.css'),
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'filters_edit' => array(
                        'type' => 'Admin/Department/Edit',
                        'template' => 'department/edit',
                    ),

                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
					'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'department',
                            'crumbinfo' => array('link' => 'admin/department/index','label' => __('Department'),'title' => __('Department')),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'admin/department/ajaxdepartment' => array(
        'content' => array(
            'children' => array(
                'departmentlist' => array(
                    'type' => 'Admin/Department/List',
                ),
            ),
        )
    ),   
    'admin/department/exportexcel' => array(
        'content' => array(
            'children' => array(
                'departmentlist' => array(
                    'type' => 'Admin/Department/Export',
                ),
            ),
        ),
    ),    
);
