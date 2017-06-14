<?php
defined('SYSPATH') OR die('No direct script access.');

return array(
    'Access_Login_Approved' => array(
        'front_loginafter' => array(
            'class' => 'user/event',
            'method' => 'loginUpdates'
        )
     ),
     'Requirement_Save_After' => array(
        'requirementinfo' => array(
            'class' => 'requirements/event',
            'method' => 'requirementinfosave'
        )
     ),
);
