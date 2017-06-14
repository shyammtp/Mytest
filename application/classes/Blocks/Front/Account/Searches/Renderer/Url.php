<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Account_Searches_Renderer_Url extends Blocks_Core_Widget_List_Column_Renderer_Action
{
    
    public function render(Kohana_Core_Object $row)
    {	
		$html = '<a target="_blank" href="'.rtrim(App::helper('front')->getUrl(),"/").$row->getData('search_url').'" class="btn btn-xs btn-white">'.$row->getData('search_url').'</a>';	
        return $html;	
	 }
	 
}
