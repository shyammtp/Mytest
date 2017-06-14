<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Users_Edit_Additionalemail extends Blocks_Store_Abstract
{
    public function getEmails()
    {
        return App::model('user/email')->setUserId($this->getUsers()->getUserId())->getEmails();
    }

}
