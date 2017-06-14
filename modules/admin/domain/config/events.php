<?php
defined('SYSPATH') OR die('No direct script access.');

return array( 
    'Admin_Website_Save_After' => array(
        'categorysave_on_website_after' => array(
            'class' => 'domain/event',
            'method' => 'categorysave'
        )
    )
);
