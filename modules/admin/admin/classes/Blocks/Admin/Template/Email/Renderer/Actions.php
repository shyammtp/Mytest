<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Template_Email_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Text
{
    public function render(Kohana_Core_Object $row)
    {
		if(App::hasTask('admin/template/edit')){
        $html = '<div class="btn-group">
                                        <a href="'.App::helper('url')->getUrl('admin/template/edit/',array('id' => $row->getData('template_id'))).'" class="btn btn-xs btn-white"><i class="fa fa-edit"></i>&nbsp;'.__('Edit').'</a>
                                        <button type="button" class="btn btn-xs btn-white dropdown-toggle" data-toggle="dropdown">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu xs pull-right" role="menu">
                                          <li><a href="'.App::helper('url')->getUrl('admin/template/view/',array('id' => $row->getData('template_id'))).'"><i class="fa fa-search"></i>&nbsp;&nbsp;'.__('Preview Template').'</a></li>';
										  if($row->getData('is_system') == 'f'){
                                           $html .=' <li class="divider"></li><li><a href="'.App::helper('url')->getUrl('admin/template/delete/',array('id' => $row->getData('template_id'))).'" onclick="SD.Common.confirm(event,\''.__("Are you sure want to delete?").'\');"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;'.__('Delete').'</a></li>';
										  }
             $html .=                      '</ul>
                                      </div>';
        return $html;
		}
    return '--';
    }

}
