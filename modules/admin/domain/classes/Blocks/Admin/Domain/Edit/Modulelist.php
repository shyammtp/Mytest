<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Domain_Edit_Modulelist extends Blocks_Admin_Abstract
{ 
    public function __construct()
    {
        
    }
    
    protected function _getModules()
    {
        return App::model('modules');
    }
    
    public function getInstalledModules()
    {
        return $this->_getModules()->installedModules($this->getRequest()->query('id'));
    }
    
    public function getNotInstalledModules()
    {
        return $this->_getModules()->installedModules($this->getRequest()->query('id'),false);
    }
}