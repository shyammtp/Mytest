<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_System_Permission_Roles_List_Renderer_Actions extends Blocks_Core_Widget_List_Column_Renderer_Action
{
    public function render(Kohana_Core_Object $row)
    {
		$html1='';
		if(App::hasTask('admin/system_permission_users/index')){
			$html1 = '<li><a href="'.App::helper('url')->getUrl('admin/system_permission_users/index/',array('filter' => base64_encode('role_name='.$row->getData('role_name')))).'"><i class="glyphicon glyphicon-tasks"></i>&nbsp;'.__('Role Users').'</a></li>
                                          <li class="divider"></li>';
		}
		
		if(App::hasTask('admin/system_permission_roles/edit')){
        $html =  '<div class="btn-group">
                                        <a href="'.App::helper('url')->getUrl('admin/system_permission_roles/edit',array('id' => $row->getData('role_id'))).'" class="btn btn-xs btn-white"><i class="fa fa-edit"></i>&nbsp;'.__('Assign task to this role').'</a>
                                        <button type="button" class="btn btn-xs btn-white dropdown-toggle" data-toggle="dropdown">
                                          <span class="caret"></span>
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <ul class="dropdown-menu xs pull-right" role="menu">
                                        '.$html1.'
                                          <li><a href="javascript:;" data-toggle="modal" data-target=".alert-'.$row->getData('role_id').'"><i class="glyphicon glyphicon-trash"></i>&nbsp;'.__('Delete this role').'</a></li>
                                        </ul>
                                      </div>';
        $html .='<div class="modal fade alert-'.$row->getData('role_id').'" tabindex="-1" role="dialog" aria-hidden="false">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                  <div class="modal-header" style="padding:9px;">
                      <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                      <h4 class="modal-title">Alert</h4>
                  </div>
                  <div class="modal-body">
                  <p class="text-info-alert">'.__('Are you sure want to delete.').'</p>
                    <a class="btn btn-danger force-delete" href="'.App::helper('url')->getUrl('admin/system_permission_roles/deleterole/',array('id' => $row->getData('role_id'),'_t' => 'force')).'">'.__('Force Delete').'</a>
                    <a class="btn btn-danger no-force-delete" href="'.App::helper('url')->getUrl('admin/system_permission_roles/deleterole/',array('id' => $row->getData('role_id'))).'">'.__('Delete').'</a>
                    <a class="btn btn-default" data-dismiss="modal">'.__('Cancel').'</a>
                  </div>
              </div>
            </div>
        </div>';
         $html .='<script>
         $(".no-force-delete").hover(function(){
            $(".text-info-alert").text("'.__('Are you sure want to delete? This will send an email notification to the user associated with the role.').'");
         });
         $(".force-delete").hover(function(){
            $(".text-info-alert").text("'.__('Are you sure want to delete? This will delete the roles without any notification to the users. ').'");
         });
         </script>';
        return $html;
		}
    return '--';
    }

}
