<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Users_Schedule extends Blocks_Store_Users_Edit
{ 
    public function getUsers()
    {
        return App::registry('users');
    }
}
