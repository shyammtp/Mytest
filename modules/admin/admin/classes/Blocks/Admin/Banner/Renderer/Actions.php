<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Banner_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Text
{
    public function render(Kohana_Core_Object $row)
    {
		if($row->getData('banner_setting_id') != 1){                           
		$html1 = '<button type="button" class="btn btn-xs btn-white dropdown-toggle" data-toggle="dropdown">
					  <span class="caret"></span>
					  <span class="sr-only">Toggle Dropdown</span>
					</button>
					<ul class="dropdown-menu xs pull-right" role="menu">
					  <li><a href="'.App::helper('url')->getUrl('admin/settings/delete_banner/',array('id' => $row->getData('banner_setting_id'))).'" onclick="SD.Common.confirm(event,\''.__("Are you sure want to delete?").'\');"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;'.__('Delete').'</a></li>
					</ul>';
		}else{
			$html1 ='';
		}	
        $html = '<div class="btn-group">
                    <a href="'.App::helper('url')->getUrl('admin/settings/edit_banner/',array('id' => $row->getData('banner_setting_id'))).'" class="btn btn-xs btn-white"><i class="fa fa-edit"></i>&nbsp;'.__('Edit').'</a>'.$html1.'</div>';
       
		
        return $html;
    }

}
