<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Store_Users_List_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Text
{
    public function render(Kohana_Core_Object $row)
    {
        $html = '<div class="btn-group">
				<a href="'.App::helper('store')->getStoreUrl('users/edit/',array('id' => $row->getData('user_id'),'name'=>$row->getData('user_type'))).'" class="btn btn-xs btn-white"><i class="fa fa-edit"></i>&nbsp;'.__('Edit').'</a>
				
			  </div>';
        return $html;
		
    }

}
