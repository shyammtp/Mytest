<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Webservice_Edit extends Blocks_Admin_Abstract
{
    public function getDefaultResourcesList()
    {
        return App::model('core/api_resources')->getAdminDefaultResources();
    }
    
    public function getApi()
    {
        return App::registry('api');
    }
    
    public function getRolesList()
    {
        $role = App::model('core/role')->toOptions();
        return $role;
    }
}
