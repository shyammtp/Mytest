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
    'search/search' => array(
        'reference' => array(			
            'maincontent' => array(
                'children' => array(
                    'searchresults' => array(
                        'type' => 'Front/Search',
                        'template' => 'search/results',
                        'children' => array(
                            'searchbar' => array(
                                'type' => 'Front/Search',
                                'template' => 'search/bar',
                            ),
                            'insurance' => array(
                                'type' => 'Front/Search/Insurance',
                                'template' => 'search/insurance',
                            ),
                            'doctors' => array(
                                'type' => 'Front/Search/Results/Doctors',
                                'template' => 'search/doctors'
                            ),
                            'clinic' => array(
                                'type' => 'Front/Search/Results/Clinic',
                                'template' => 'search/clinics'
                            ),
                            'labs' => array(
                                'type' => 'Front/Search/Results/Labs',
                                'template' => 'search/labs'
                            ),
                            'breadcrumbs' => array (
                                'type' => 'Front/Breadcrumb',
                                'template' => 'page/breadcrumbs',
                                'actions' => array(
                                    'homeaction1' => array(
                                        'method' => 'addCrumb',
                                        'attributes' => array(
                                            'crumbname' => 'home',
                                            'crumbinfo' => array('link' => '/','label' => __('Home'),'title' => __('Home')),
                                        ),
                
                                    ),
                                ),
                            ),
                        )
                    ),                    
                )
            ),   
            'head' => array(
                'attributes' => array(
                    'title' => 'Search',
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
    ),
);
