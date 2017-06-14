<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Breadcrumb extends Blocks_Admin_Abstract
{
    protected $_crumbs;
    
    public function addCrumb($crumbName, $crumbInfo, $after = false)
    {
        $this->_prepareArray($crumbInfo, array('label', 'title', 'link', 'first', 'last', 'readonly')); 
        
        if ((!isset($this->_crumbs[$crumbName])) || (!$this->_crumbs[$crumbName]['readonly'])) {
           $this->_crumbs[$crumbName] = $crumbInfo;
        }
        return $this;
    }
    
    public function getCrumbs()
    {
        $this->_prepareBreadcrumb(); 
        return $this->_crumbs;
    }
    
    public function _prepareBreadcrumb()
    {
        if (is_array($this->_crumbs)) {
            reset($this->_crumbs);
            $this->_crumbs[key($this->_crumbs)]['first'] = true;
            end($this->_crumbs);
            $this->_crumbs[key($this->_crumbs)]['last'] = true;
        }
        return $this;
    }
    
     
}
