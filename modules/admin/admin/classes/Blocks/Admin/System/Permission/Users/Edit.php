<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Permission_Users_Edit extends Blocks_Admin_Abstract
{

    protected function _helper()
    {
        return App::helper('admin');
    }

    public function getRolesList()
    {
        $role = App::model('core/role')->toOptions();
        return $role;
    }

    public function getCustomerLists()
    {
        $customers =App::model('user');
        $customers->getCustomers();
        return $customers->toOptions();
    }

    public function loadDBData()
    {
        $user = App::model('core/role_users')->load($this->getRequest()->query('id'));
        $this->setData($user->getData());
        return $this;
    }

    public function getUser()
    {
        $user = App::model('user',false)->load($this->getUserId());
        return $user;
    }
}
