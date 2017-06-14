<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Template_Email_Renderer_System extends Blocks_Core_Widget_List_Column_Renderer_Text
{
    public function render(Kohana_Core_Object $row)
    {
		if($row->getData('is_system') == '1'){ 
			$html = '<span class="label label-info">'.__('System').'</span>';
		} else { 
			$html = '<span class="label label-success">'.__('Custom').'</span>';
		}
        return $html;
		 
    }

}
