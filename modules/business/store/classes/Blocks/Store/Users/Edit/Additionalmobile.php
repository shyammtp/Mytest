<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Users_Edit_Additionalmobile extends Blocks_Store_Abstract
{
    public function getContacts()
    {
        return App::model('user/contacts')->setUserId($this->getUsers()->getUserId())->getContacts();
    }

}
