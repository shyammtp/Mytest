<?php
defined('SYSPATH') OR die('No direct script access.');

return array( 
    'models' => array(
        'Core/Tasks' => 'Store/Tasks'
    ),
    'blocks' => array(
        'Store/System/Permission/Roles/Edit' => 'Store/System/Permission/Tasks'
    ),
);
