<?php
$blockname = 'general';
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
                'active' => 'settings/general',  
            ),
        ),
		'bottomincludes' => array(
			'actions' => array(
				'appendThemeJs' => array(
					'src' => array('js/custom.js','js/bootstrap-timepicker.min.js'),
				),
			),
            'children' => array(
                'dashboardjs' => array(
                    'type' => 'Store/Page/Js', 
                    'template' => 'settings/general/js',
                ),
            ),
        ), 
        'content' => array(
            'attributes' => array(
                'body_class'  => $blockname.'_class page-header-fixed',
                 'title_icon' => '<i class="fa fa-cog" ></i>&nbsp;',
                'page_title' => 'General Settings',
            ),
        ),
        'head' => array( 
            'attributes' => array(
                'title' => 'General / Settings - Store',  
            ),
                'actions' => array(
                   'appendThemeCss' => array(
                        'src' => array('css/select2.css','css/bootstrap-timepicker.min.css'),
                    ),
                ),
        ), 
        'maincontent' => array(  
            'children' => array(
                'forms' => array(
                    'type' => 'Configuration/Elements',
                    'template' => 'configuration/elements',
                ),
            ),
        ), 
        'breadcrumbs' => array( 
            'actions' => array(
                'action1' => array(
                    'method' => 'addCrumb',
                    'attributes' => array(
                        'crumbname' => 'settings',
                        'crumbinfo' => array('link' => 'admin/settings/general','label' => __('Settings'),'title' => __('Settings')),
                    ),
                     
                ),
                 
            ),
        ), 
    ),
);
