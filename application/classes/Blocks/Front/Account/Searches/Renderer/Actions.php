<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Searches_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Action
{
    
    public function render(Kohana_Core_Object $row)
    {	
	
		$html = '<div class="btn-group"><ul><li><a onclick="return confirm(\''.__("Are you sure want to delete this search?").'\');" href="'.App::helper('front')->getUrl('account/blocksearch',array('id' => $row->getData('id'))).'" class="btn btn-xs btn-white">'.__('Delete').'</a></li></ul></div>';	
				
        return $html;
	
	 }


}
