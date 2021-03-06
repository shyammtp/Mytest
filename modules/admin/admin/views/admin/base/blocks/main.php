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
                    'appendThemeJs' => array(
                            'src' => array('js/flot/jquery.flot.min.js','js/flot/jquery.flot.min.js','js/flot/jquery.flot.resize.min.js','js/flot/jquery.flot.spline.min.js','js/flot/jquery.flot.pie.js','js/jquery.sparkline.min.js','js/morris.min.js','js/raphael-2.1.0.min.js','js/custom.js','js/dashboard.js','js/jquery-ui-1.10.3.min.js','plugins/Highcharts/js/highcharts.js','plugins/Highcharts/js/modules/exporting.js','js/bizbox.js','plugins/timepicker/moment.js','plugins/timepicker/bootstrap-datetimepicker.min.js'),
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
                'actions' => array(
				
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/morris.css'),
                    ),
                ),
            ),
            'maincontent' => array(
                'children' => array(
                    'dashboard' => array(
						'type' => 'Admin/Dashboard/Dashboard',
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
                            'crumbinfo' => array('link' => 'index','label' => 'Home','title' => 'Home'),
                        ),

                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'layout',
                            'crumbinfo' => array('label' => 'Dashboard','title' => 'Dashboard'),
                        ),

                    ),
                ),
            ),
        ),
    ),
    'admin/system/cache' => array(
        'reference' => array(
            'leftmenu' => array(
                'attributes' => array(
                    'active' => 'system/cache',
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
                    'page_title' => 'Cache Management',
                ),
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Cache / System - Admin',
                ),
            ),
            'maincontent' => array(
                'actions' => array(
                    'setTemplate' => array(
                        'template' => 'system/cache',
                    ),
                ),
                'children' => array(
                    'cache_grid_list' => array(
                        'type' => 'Admin/System/Cache/List'
                    ),
                ),
            ),
            'breadcrumbs' => array(
                'actions' => array(
                    'action1' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'system',
                            'crumbinfo' => array('link' => 'admin/system/cache.do','label' => __('System'),'title' => __('System')),
                        ),

                    ),
                    'action2' => array(
                        'method' => 'addCrumb',
                        'attributes' => array(
                            'crumbname' => 'cache',
                            'crumbinfo' => array('label' => __('Cache'),'title' => __('Cache')),
                        ),

                    ),
                ),
            ),
        ),
    ),
    'admin/system/cacheajax' => array(
        'reference' => array(
            'maincontent' => array( 
                'children' => array(
                    'cache_grid_list' => array(
                        'type' => 'Admin/System/Cache/List'
                    ),
                ),
            ),
        ),
    ),
    'admin/dashboard/loadnotificationajax' => array(
        'content' => array(
            'children'=>array(
            'ajax' => array(   
                'type' => 'Admin/Dashboard/Dashboard',
                'template' => 'dashboard/message/notifications'
                ),
            ),
        ),
    ),
    'admin/search/keyword' => array(
        'content' => array(
            'type' => 'Admin/Search',
            'template' => 'search/keywords'
        ),
    ),
    'admin/dashboard/getlocations' => array(
        'content' => array(
            'children' => array(
                'loc' => array(
                     'type' => 'Admin/City/Locations',
                     'template' => 'city/locations/areas'
                ),
            ),           
        ),
    ),
);
