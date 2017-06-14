<?php
defined('SYSPATH') OR die('No direct script access.');

/*
 *
 * Resource are will be in order
 */ 
return array(
    'admin' => array(
        'products' => array(
            'title' => 'Products',
            'description' => 'Managing Products',
            'resource' => array (
                'GET','POST','PUT','DELETE'
            )
        ),
        'service' => array(
           'title' => 'Service',
            'description' => 'Managing Service',
            'resource' => array (
                'GET','POST','PUT','DELETE'
            )
        ),
        'promotions' => array(
           'title' => 'Promotions',
            'description' => 'Managing Promotions',
            'resource' => array (
                'GET','POST','PUT','DELETE'
            )
        ),
        'order_management' => array(
           'title' => 'Order Management',
            'description' => 'Managing Orders',
            'resource' => array (
                'GET','POST','PUT','DELETE'
            )
        ),
        'user_requirement' => array(
           'title' => 'User Requirement Managements',
            'description' => 'Managing User Requirements',
            'resource' => array (
                'GET','POST','PUT','DELETE'
            )
        ), 
     ),
);
