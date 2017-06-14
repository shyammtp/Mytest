<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Page extends Blocks_Admin_Abstract
{
    protected function _toHtml()
    {  
        return parent::_toHtml();
    }
     
    public function getClassNames()
    {
        $uniqueclass = str_replace("/","_",$this->getRequest()->uri());
        $calledclass = $this->getBodyClass();
        return $uniqueclass." ".$calledclass;
    }
    
    public function getPageTitle()
    {
        return __($this->getData('page_title'));
    }
}