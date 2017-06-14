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
    'login/index' => array(
        'reference' => array(
			'content'=>array(
			'attributes' => array(
                    'body_class' => 'landingpage',
                ),
			),
            'maincontent' => array(
                'children' => array(
                    'loginpage' => array(
                        'type' => 'Front/Login',
                        'template' => 'login',
                    ),   
                    'index' => array(
                        'type' => 'Front/Index',
                        'template' => 'index',
                        'children' => array(
                            'searchbar' => array(
                                'type' => 'Front/Search',
                                'template' => 'search/homebar',  
                            ),
                        )
                    ),                  
                )
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Login',
                ),
                'actions' => array(
                    'appendThemeJs' => array(
                        'src' => array('js/select2.min.js','plugins/autocomplete/jquery.autocomplete.js'),
                    ),
                    'appendThemeCss' => array(
                        'src' => array('plugins/autocomplete/jquery.autocomplete.css','css/jquery-ui-1.10.3.css','css/select2.css')
                    ),
                ),
            ),
			
        ),
    ),'login/access' => array(
        'content' => array(
			'type' => 'Front/Page',   
			'template' => 'login/social_access',         
        ),
    ),
    
    'account/resetpassword' => array(
        'reference' => array(
            'maincontent' => array(
                'children' => array(
                    'loginpage' => array(
                        'type' => 'Front/Login',
                        'template' => 'resetpassword',
                    ),                    
                )
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Message / System - Admin',
                ),
                'actions' => array(
                    'appendThemeCss' => array(
                        'src' => array('plugins/search/jquery.autocomplete.css'),
                    ),
                ),
            ),
			
        ),
    ),
    
    
    'login/forgetpassword' => array(
        'reference' => array(
            'maincontent' => array(
                'children' => array(
                    'forgetpassword' => array(
                        'type' => 'Front/Login',
                        'template' => 'forgetpassword',
                    ),                    
                )
            ),
            'head' => array(
                'attributes' => array(
                    'title' => 'Forget Password',
                ),
                'actions' => array(
                    'appendThemeCss' => array(
                        'src' => array('plugins/search/jquery.autocomplete.css'),
                    ),
                ),
            ),
			
        ),
    )
);
