<?php
$blockname = 'dashboard';
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
    'admin/dashboard/index' => array(
        'reference' => array(
            'leftmenu' => array( 
                'attributes' => array(
                    'active' => 'dashboard/index',  
                ),
            ),
            'bottomincludes' => array(  
                'actions' => array(
                    'appendJs' => array(
                        'src' => array('js/jquery-ui-1.10.3.min.js','js/custom.js','plugins/autocomplete/jquery.autocomplete.js','js/bizbox.js','plugins/timepicker/moment.js','plugins/timepicker/bootstrap-datetimepicker.min.js'),
                    ),
                ), 
            ), 
            'content' => array(
                'attributes' => array(
                    'body_class'  => $blockname.'_class page-header-fixed',
                    'page_title' => 'Admin Dashboard',
                ),
            ),
            'head' => array( 
                'attributes' => array(
                    'title' => 'Admin Dashboard',  
                ),
            ), 
            
            'maincontent' => array(
                'actions' => array(
                    'setTemplate' => array(
						'type' => 'Admin/Dashboard',
                        'template' => 'dashboard/index',
                    ),
                ), 
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
    ),
    'admin/dashboard/report' => array(
        'content' => array(
            'children' => array(
                'report' => array(
                    'type' => 'Admin/Dashboard/Report',
                ),
            ),
        )
    ),
);
