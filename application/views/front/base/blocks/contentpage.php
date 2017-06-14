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
    'home/aboutus' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'aboutus' => array(
                        'type' => 'Front/Aboutus',
                        'template' => 'aboutus',
                         'children' => array(
							'searchbar' => array(
									'type' => 'Front/View/Searchbar',
									'template' => 'search/bar',
							 )  
						 ), 
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'About Us',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),         
			
        ),
    ),
    'home/contactus' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'contactus' => array(
                        'type' => 'Front/Contactus',
                        'template' => 'contactus',
                         'children' => array(
							'searchbar' => array(
									'type' => 'Front/View/Searchbar',
									'template' => 'search/bar',
							 )  
						 ), 
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Contact us',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),         
			
        ),
    ), 
    
    'home/howtobook' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'howtobook' => array(
                        'type' => 'Front/Howtobook',
                        'template' => 'howtobook',
                         'children' => array(
							'searchbar' => array(
									'type' => 'Front/View/Searchbar',
									'template' => 'search/bar',
							 )  
						 ), 
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Users',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),         
			
        ),
    ), 
   
);
