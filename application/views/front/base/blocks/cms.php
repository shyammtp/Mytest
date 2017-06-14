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
 * - template (optional) - If doesnt defined here need to define in the constructor of the block class.
 * - Children (optional) -  Children will be used to access the block and template inside another block.
 * - attributes (optional) - Values can get into the template file or block file using setter and getter method.
 */
 
return array(
    'cms/page/index' => array(
        'reference' => array(
            'maincontent' => array(
                'children' => array(
                    'cmspage' => array(
                        'type' => 'Front/Cmspage',
                        'template' => 'cms/page',
                    ),                 
                )
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Login',
                ),
                'actions' => array(
                    /*'appendThemeJs' => array(
                        'src' => array('plugins/search/jquery.autocomplete.js'),
                    ),*/
                    'appendThemeCss' => array(
                        'src' => array('plugins/search/jquery.autocomplete.css'),
                    ),
                ),
            ),
			
        ),
    ),
    'cms_page/api' => array(
        'reference' => array(
            'content' => array(
              'template' => 'column/mobile',  
            ),
            'maincontent' => array(
                'children' => array(
                    'cmspage' => array(
                        'type' => 'Front/Cmspage',
                        'template' => 'cms/mobile',
                    ),                 
                )
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Login',
                ),
                'actions' => array(
                    /*'appendThemeJs' => array(
                        'src' => array('plugins/search/jquery.autocomplete.js'),
                    ),*/
                    'appendThemeCss' => array(
                        'src' => array('plugins/search/jquery.autocomplete.css'),
                    ),
                ),
            ),
			
        ),
    ),
);
