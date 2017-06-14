<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Renderer_MessageContent extends Blocks_Core_Widget_List_Column_Renderer_Abstract
{
    public function render(Kohana_Core_Object $row)
    {		
		$html = '';
		$class="";     
			$string = strip_tags($row->getMessage());
			$strlen = strlen($string);
			if($strlen > 50) {
				$message = substr($string,0,50).'...';
			} else {
				$message = $string;
			}
            $html .= $message;
        return $html;
        
	}
	
	public function getLanguages()
    {
        return App::model('core/language')->getLanguages();
    }
}
