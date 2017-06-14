<?php
defined('SYSPATH') OR die('No direct script access.');

return array( 
    'models' => array(
        'Core/Tasks' => 'Admin/Tasks'
    ),
    'blocks' => array(
        'Admin/System/Permission/Roles/Edit' => 'Admin/System/Permission/Tasks'
    ),
);
