<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Index extends Blocks_Front_Abstract
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
}
