<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Webservice_List_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Action
{
    public function render(Kohana_Core_Object $row)
    {
        $html =  '<div class="btn-group">
                                        <a href="'.App::helper('url')->getUrl('admin/system_webservice/edit',array('id' => $row->getData('account_id'))).'" class="btn btn-xs btn-white"><i class="fa fa-edit"></i>&nbsp;'.__('Edit').'</a>
                                        <button type="button" class="btn btn-xs btn-white dropdown-toggle" data-toggle="dropdown">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu xs pull-right" role="menu"> 
                                          <li><a href="'.App::helper('url')->getUrl('admin/system_webservice/delete/',array('id' => $row->getData('account_id'))).'" onclick="SD.Common.confirm(event,\''.__("Are you sure want to delete?").'\');"><i class="glyphicon glyphicon-trash"></i>&nbsp;'.__('Delete').'</a></li>
                                        </ul>
                                      </div>';
        return $html;
    }

}
