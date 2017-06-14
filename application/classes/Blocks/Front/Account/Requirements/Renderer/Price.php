<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Requirements_Renderer_Price extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{ 
    public function render(Kohana_Core_Object $row)
    {
		
		$html = '';
		$html = number_format($row->getData($this->getColumn()->getIndex()),2);
		
        return $html;
        
	}
	
	public function getLanguages()
    {
        return App::model('core/language')->getLanguages();
    }
}
