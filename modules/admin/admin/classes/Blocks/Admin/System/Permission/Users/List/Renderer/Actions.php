<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Permission_Users_List_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Action
{
    public function render(Kohana_Core_Object $row)
    {
		$html1='';
		if(App::hasTask('admin/system_permission_roles/index')){
			$html1 = '<li><a href="'.App::helper('url')->getUrl('admin/system_permission_roles/edit/',array('id' => $row->getData('role_id'))).'"><i class="glyphicon glyphicon-tasks"></i>&nbsp;'.__('Modify task for this role').'</a></li>
                                          <li class="divider"></li>';
		}
		if(App::hasTask('admin/system_permission_users/edit')){
        $html = '<div class="btn-group">
                                        <a href="'.App::helper('url')->getUrl('admin/system_permission_users/edit',array('id' => $row->getData('ruid'))).'" class="btn btn-xs btn-white"><i class="fa fa-edit"></i>&nbsp;'.__('Edit').'</a>
                                        <button type="button" class="btn btn-xs btn-white dropdown-toggle" data-toggle="dropdown">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu xs pull-right" role="menu">
                                          '.$html1.'
                                          <li><a href="'.App::helper('url')->getUrl('admin/system_permission_users/deleterole_users/',array('id' => $row->getData('ruid'))).'"><i class="glyphicon glyphicon-trash"></i>&nbsp;'.__('Delete this user role').'</a></li>
                                        </ul>
                                      </div>';
        return $html;
		}
    return '--';
    }

}
