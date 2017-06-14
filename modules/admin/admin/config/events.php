<?php
defined('SYSPATH') OR die('No direct script access.');

return array(
    'Place_Category_Save_After' => array(
        'categoryinfosave' => array(
            'class' => 'core/event',
            'method' => 'categoryinfosave'
        )
     ),
    'Country_Save_After' => array(
        'countrysaveafter' => array(
            'class' => 'admin/event',
            'method' => 'countrysaveafter'
        )
    ),'city_Save_After' => array(
        'citysaveafter' => array(
            'class' => 'admin/event',
            'method' => 'citysaveafter'
        )
    ),
    'Area_Save_After' => array(
        'areasaveafter' => array(
            'class' => 'admin/event',
            'method' => 'areasaveafter'
        )
    ),
    'Department_Save_After' => array(
        'departaveafter' => array(
            'class' => 'admin/event',
            'method' => 'departmentsaveafter'
        )
    ),
    /*'Admin_Login_After' => array(
        'logentry' => array(
            'class' => 'admin/event',
            'method' => 'loginactivity'
        )
    ),*/
    'Admin_Logout_Before' => array (
        'logentry_logout' => array(
            'class' => 'admin/event',
            'method' => 'logoutactivity'
        )
    ),
    'Place_Delete_Before' => array (
        'related_place_delete' => array(
            'class' => 'admin/event',
            'method' => 'related_place_delete'
        )
    ),
    'Webservice_Api_Save_After' => array(
        'service_api_save_after' => array(
            'class' => 'admin/event',
            'method' => 'api_account_store_save'
        )
    ),
    
   'Roleusers_Save_After' => array(
        'roleusers_save_before' => array(
            'class' => 'admin/event',
            'method' => 'roleusers_save_after'
        )
    ),
    'Adverts_Save_After' => array(
        'advert_info_save' => array(
            'class' => 'admin/event',
            'method' => 'advertsinfo',
        ),
    ),
    'Product_Save_After' => array(
        'product_categorysave' => array(
            'class' => 'admin/event',
            'method' => 'product_categorysave'
        ),
        'product_brandsave' => array(
            'class' => 'admin/event',
            'method' => 'product_brandsave'
        ),
        'product_attributesave' => array(
            'class' => 'admin/event',
            'method' => 'product_attributesave'
        ),
        'product_tagsave' => array(
            'class' => 'admin/event',
            'method' => 'product_tagsave'
        ),
        'product_subproductupdate' => array(
            'class' => 'admin/event',
            'method' => 'product_subproductupdate'
        ),
    ),
    'Product_Delete_Before' => array(
        'product_tagdelete' => array(
            'class' => 'admin/event',
            'method' => 'producttagDelete'
        ), 
    ),
    'Email_Subject_Save_After' => array(
        'subject_save' => array(
            'class' => 'admin/event',
            'method' => 'subjectsave'
        ), 
    ),
    'Configuration_Admin_Save_After' => array(
        'api_key_save' => array(
            'class' => 'admin/event',
            'method' => 'api_key_save'
        ), 
    ), 
   
);
