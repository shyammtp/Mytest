<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Settings_List extends Blocks_Admin_Page_Sidebar
{
    protected $_menus;

    public function getSettingsConfig()
    {
        $config = Kohana::$config->load('adminmenu');
        $settingsMenu = array('settings' => $config->get('settings'));
        return parent::_loadMenus($settingsMenu);
    }

    protected function _helper()
    {
        return App::helper('admin');
    }



}