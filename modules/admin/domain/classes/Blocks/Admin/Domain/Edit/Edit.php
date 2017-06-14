<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Domain_Edit_Edit extends Blocks_Admin_Abstract
{ 
    public function __construct()
    {
        
    }
    
    protected function _getWebsite()
    {  
        return App::model('core/website')->load($this->getRequest()->query('id'));
    }
    
    protected function _getCategory($cate_id)
    { 
        return App::model('core/category')->load($cate_id);
    }
    
    
}

