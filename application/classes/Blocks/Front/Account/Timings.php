<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Timings extends Blocks_Front_Abstract
{
    public function getUsers()
    {
        return App::registry('users');
    }
}
