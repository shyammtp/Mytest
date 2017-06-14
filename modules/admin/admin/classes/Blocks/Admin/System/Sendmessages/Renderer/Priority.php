<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Sendmessages_Renderer_Priority extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{
    public function render(Kohana_Core_Object $row)
    {		
		$html = '';
		$class="";    
		switch($row->getPriority()) {
			case 'normal':
				$priority = 'default';
				break;
			case 'urgent':
				$priority = 'warning';
				break;
			case 'important':
				$priority = 'success';
				break;
			case 'error':
				$priority = 'danger';
				break;										 
		}
		$html .= '<span class="label label-'.$priority.'">'.ucfirst($row->getPriority()).'</span>';	        
        return $html;
        
	}
	
	public function getLanguages()
    {
        return App::model('core/language')->getLanguages();
    }
}
