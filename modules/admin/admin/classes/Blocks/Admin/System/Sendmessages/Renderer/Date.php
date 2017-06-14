<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Sendmessages_Renderer_Date extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{
    public function render(Kohana_Core_Object $row)
    {		
		$html = '';
		$class="";            
            $html .= (date("M d,Y", strtotime($row->getPostDate())) ? date("M d,Y", strtotime($row->getPostDate())) : '-');            
        
        return $html;
        
	}
	
	public function getLanguages()
    {
        return App::model('core/language')->getLanguages();
    }
}
