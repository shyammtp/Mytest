<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Requirements_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Action
{
    
    public function render(Kohana_Core_Object $row)
    {	
		
		if($row->getData('status') == 0) {	
			$html = __('Closed');
		} else {
			$html = '<div class="btn-group"><ul><li><a href="'.App::helper('front')->getUrl('account/editrequirement',array('id' => $row->getData('requirement_id'))).'" class="btn btn-xs btn-white">'.__('View').'</a></li><li><a href="'.App::helper('front')->getUrl('account/blockrequirement',array('id' => $row->getData('requirement_id'))).'" class="btn btn-xs btn-white">'.__('Fulfilled').'</a></li></ul></div>';	
		}		
        return $html;
	
	 }


}
