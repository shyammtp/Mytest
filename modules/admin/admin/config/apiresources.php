<?php
defined('SYSPATH') OR die('No direct script access.');

/*
 *
 * Resource are will be in order
 */ 
return array(
    'admin' => array(
        'company' => array(
            'title' => 'Company',
            'description' => 'Managing place (company)',
            'resource' => array (
                'GET','POST','PUT','DELETE'
            )
        ),
        /**'users' => array(
           'title' => 'Users',
            'description' => '',
            'resource' => array (
                'GET','POST','PUT','DELETE'
            )
        ),
        **/
        'store' => array(
           'title' => 'Store',
            'description' => '',
            'resource' => array (
                 'GET','POST','PUT','DELETE'
            )
        ),
        'education' => array(
           'title' => 'Education',
            'description' => '',
            'resource' => array (
                 'GET','POST','PUT','DELETE'
            )
        ),
        'healthcare' => array(
           'title' => 'Healthcare',
            'description' => '',
            'resource' => array (
                 'GET','POST','PUT','DELETE'
            )
        ),
        'parking' => array(
           'title' => 'Parking',
            'description' => '',
            'resource' => array (
                 'GET','POST','PUT','DELETE'
            )
        ),
        'garden' => array(
           'title' => 'Garden',
            'description' => '',
            'resource' => array (
                 'GET','POST','PUT','DELETE'
            )
        ),
        'religious' => array(
           'title' => 'Religious',
            'description' => '',
            'resource' => array (
                 'GET','POST','PUT','DELETE'
            )
        ),
        'property' => array(
           'title' => 'Property',
            'description' => '',
            'resource' => array (
                 'GET','POST','PUT','DELETE'
            )
        ),
     ),
);
