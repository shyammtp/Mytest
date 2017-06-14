<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Sendmessages_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Text
{
    public function render(Kohana_Core_Object $row)
    {
		$html='--';
		if(App::hasTask('admin/system/message')){
			$row->getData($this->getColumn()->getIndex())?$status=0:$status=1;		  
			
			$html = '<div class="btn-group">
				<a href="'.App::helper('url')->getUrl('admin/system/reply_message',array('id' => $row->getData('msg_id'),'type' => 'sent')).'" class="btn btn-xs btn-white"><i class="fa fa-edit"></i>&nbsp;'.__('Reply').'</a>
				<button type="button" class="btn btn-xs btn-white dropdown-toggle" data-toggle="dropdown">
				  <span class="caret"></span>
				  <span class="sr-only">Toggle Dropdown</span>
				</button>                  
				<ul class="dropdown-menu xs pull-right" role="menu">											                       
					<li><a  href="'.App::helper('url')->getUrl('admin/system/delete_sendmessage',array('id' => $row->getData('msg_id'))).'" onclick="SD.Common.confirm(event,\''.__("Are you sure want to delete?").'\');"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;'.__('Delete').'</a></li>
				</ul>
			  </div>';
        }
        return $html;
    }

}
