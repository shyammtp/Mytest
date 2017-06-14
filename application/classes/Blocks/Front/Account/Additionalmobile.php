<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Additionalmobile extends Blocks_Front_Abstract
{
    public function getContacts()
    {
        return App::model('user/contacts')->setUserId($this->getUsers()->getUserId())->getContacts();
    }

}
