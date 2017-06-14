<?php defined('SYSPATH') OR die('No direct script access.');

return array(
    'url_rewrite' => array(
        'title' => 'Url Rewrite',
        'sort' => '100',
                'children' => array(
					/** 'adverts' => array(
                        'title' => 'Adverts',
                        'task_note' => 'Manage Adverts',
                        'task_index' => '["admin/adverts/advert"]',
                        'sort' => '1'
                    ),
                    'editadvert' => array(
                                'title' => 'Adverts Edit',
                                'task_note' => 'Edit, Block, delete the Adverts',
                                'task_index' => '["admin/adverts/edit_advert","admin/adverts/blockunblockadvertsblock","admin/adverts/delete_advert"]',
                                'sort' => '2',
                    ),
                    ***/
                    'urlrewrite' => array(
                        'title' => 'Url Rewrite',
                        'task_note' => 'Manage Url',
                        'task_index' => '["domain/list/urlrewrite","domain/list/ajaxload"]',
                        'sort' => '3'
                    ),
                    'editurl' => array(
                                'title' => 'Url Rewrite Edit',
                                'task_note' => 'Edit,delete the Url',
                                'task_index' => '["domain/list/edit_url","domain/list/saveurl","domain/list/urlrewrite","domain/list/delete_url"]',
                                'sort' => '4',
                    ),                                          
        )
    )
); 

