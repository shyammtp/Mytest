<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Requirements_Renderer_Places extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{ 
    public function render(Kohana_Core_Object $row)
    {
		$html = '';
		if($row->getData($this->getColumn()->getIndex()) == 0) {
			$html = __('This requirement doesn\'t matched any of store');	
		} else {
			$html = $row->getData($this->getColumn()->getIndex());
		}
		
        return $html;
        
	}
	
	public function getLanguages()
    {
        return App::model('core/language')->getLanguages();
    }
}
