<?php
defined('SYSPATH') OR die('No direct script access.');

return array(
    'Store_Admin_Login_After' => array(
        'storeadminlogin_after' => array(
            'class' => 'store/adminevent',
            'method' => 'afterLogin'
        ),
        'logentry' => array(
            'class' => 'store/adminevent',
            'method' => 'loginactivity'
        ),
    ),
    'Store_Save_After' => array(
        'storeinfosave' => array(
            'class' => 'store/event',
            'method' => 'storeinfosave'
        )
    ),
    'Store_Login_After' => array(
        'badminlogin_after' => array(
            'class' => 'store/adminevent',
            'method' => 'checkAllAccess'
        ),
        'setdefaultplace' => array(
            'class' => 'store/adminevent',
            'method' => 'setDefaultplaceid'
        )
    ),
    'Store_Admin_Logout_Before' => array (
        'logentry_logout' => array(
            'class' => 'store/adminevent',
            'method' => 'logoutactivity'
        )
    ),
    'Department_Save_After' => array(
        'departaveafter' => array(
            'class' => 'store/event',
            'method' => 'departmentsaveafter'
        )
    ),
	'Webservice_Api_Save_After' => array(
        'service_api_save_after' => array(
            'class' => 'store/adminevent',
            'method' => 'api_account_store_save'
        )
    ),
    'Rating_Question_Save_After' => array(
        'question_infosave' => array(
            'class' => 'store/rating/event',
            'method' => 'question_infosave'
        )
    ),
    'Rating_Peoplequestion_Save_After' => array(
        'question_infosave' => array(
            'class' => 'store/rating/people/event',
            'method' => 'question_infosave'
        )
    ),
    'People_Save_After' => array(
        'pepole_infosave' => array(
            'class' => 'store/adminevent',
            'method' => 'people_infosave'
        )
    ),
    'Requirement_Store_Save_After' => array(
        'requirementinfo' => array(
            'class' => 'store/requirements/event',
            'method' => 'requirementinfosave'
        )
     ),
     'Reqirement_Save_After' => array(
        'Reqirement_Status_Save' => array(
            'class' => 'store/requirements/event',
            'method' => 'requirementstatussave',
        ),
    ),
    'Banner_Save_After' => array(
        'place_banner_Save' => array(
            'class' => 'store/banner/event',
            'method' => 'bannerinfosave',
        ),
        'bannerlocationsave' => array(
            'class' => 'store/banner/event',
            'method' => 'location_save',
        ),
    ),
    
    
    
);
