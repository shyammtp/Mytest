<?php
$blockname = 'areasettings';
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
    'admin/settings/areasettings' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'countrysettings/area',
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
                    'page_title' => 'Area',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Area',
                ),
            ),
            'maincontent' => array(
                'children' => array(
					'arealisting' => array(
						'type' => 'Store/Area/List',
					),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'Area',
                            'crumbinfo' => array('label' => __('Area'),'title' => __('Area')),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'admin/settings/editarea' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'countrysettings/area',
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
                    'page_title' => 'Area Edit',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Area Edit',
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
                        'type' => 'Admin/Area/Edit',
                        'template' => 'area/edit',
                    ),

                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
					'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'area',
                            'crumbinfo' => array('link' => 'admin/settings/areasettings','label' => __('Area'),'title' => __('Area')),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'admin/settings/ajaxarea' => array(
        'content' => array(
            'children' => array(
                'arealist' => array(
                    'type' => 'Admin/Area/List',
                ),
            ),
        )
    ),  
    'admin/settings/getcity' => array(
        'content' => array(
            'children' => array(
                'city' => array(
                     'type' => 'Admin/Area/Edit',
                     'template' => 'area/city'
                ),
            ),           
        ),
    ),     
    'admin/settings/getarea' => array(
        'content' => array(
            'children' => array(
                'area' => array(
                     'type' => 'Admin/Area/Edit',
                     'template' => 'area/area'
                ),
            ),           
        ),
    ),     
);
