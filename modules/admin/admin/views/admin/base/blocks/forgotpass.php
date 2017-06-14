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
    'reference' => array(
        'maincontent' => array(
            'children' => array(
                'forgot_form' => array(
                    'type' => 'Admin/Forgotpass',
                    'template' => 'login/forgotpass'
                ),
            ), 
        ),
        'bottomincludes' => array(
               'type' => 'Admin/Page/Js',
               'template' => 'login/js',
               /*'actions' => array(
                   'appendJs' => array(
                       'src' => array('scripts/app.js', 'scripts/login-soft.js'),
                   ),
               ),*/
           ),
        'head' => array(
                'type' => 'Admin/Page/Head',
                'template' => 'page/head',
                /*'actions' => array(
                    'appendCss' => array(
                        'src' => 'css/pages/login.css', 
                    ), 
                ),*/
            ),
        'content' => array(
            'attributes' => array(
                'body_class'  => 'signin',
            ),
            'actions' => array(
                'setTemplate' => array(
                    'template' => 'column/1column',
                ),
            ),
        ),
    ),
);
