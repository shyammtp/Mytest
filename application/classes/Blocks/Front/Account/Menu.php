<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Menu extends Blocks_Front_Abstract
{
    public function __construct()
    {
        $this->setTemplate('account/menu');
    }
 
 
    public function getUser()
    {
        return App::model('user/session')->getCustomer();
    }
}
