<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_System_Permission_Users extends Controller_Core_Admin {

	public function action_index()
	{
		$this->loadBlocks('system/permission/users');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Role Users Management'));
		$contentblock->setPageTitle('<i class="fa fa-users" ></i>&nbsp;'.__('Role Users Management'));
		$this->renderBlocks();
	}

	public function action_new()
	{
		$this->loadBlocks('system/permission/users');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Role Users Management'));
		$contentblock->setPageTitle('<i class="fa fa-users" ></i>&nbsp;'.__('Role Users Management'));
		$this->renderBlocks();
	}

	public function action_edit()
	{
		$this->loadBlocks('system/permission/users');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Role Users Management'));
		$contentblock->setPageTitle('<i class="fa fa-users" ></i>&nbsp;'.__('Role Users Management'));
		$this->renderBlocks();
	}

	public function action_ajax()
	{
		$this->loadBlocks('system/permission/users');
		$output=$this->getBlock('users_list_grid')->toHtml();
		$this->getResponse()->body($output);
	}

	public function action_tasks()
	{
		$this->auto_render = false;
		if(!$this->getRequest()->is_ajax()) {
			$this->page404();
			return;
		}
		$roletasks = App::model('core/role_tasks')->getTasks($this->getRequest()->query('id'));
		$task = json_encode(App::model('core/tasks')->setRoleTasks($roletasks)->toOptionArray());
		echo $task;

	}

	public function action_save()
	{
		$data = $this->getRequest()->post();
		if($data) {
			if(!isset($data['role_id'])) {
				Notice::add(Notice::ERROR, __('Roles must not be empty'));
				$this->_redirect('admin/system_permission_users/edit',array('id' => $data['ruid']));
			}
			if(!isset($data['customer_id'])) {
				Notice::add(Notice::ERROR, __('Invalid user selected'));
				$this->_redirect('admin/system_permission_users/edit',array('id' => $data['ruid']));
			}
			$user = App::model('user')->load($data['customer_id']);
			if(!$user->getUserId()) {
				Notice::add(Notice::ERROR, __('Invalid user selected'));
				$this->_redirect('admin/system_permission_users/edit',array('id' => $data['ruid']));
			}
			$model = App::model('core/role_users');
			if($model->checkHasRole($data['ruid'], $data['role_id'],$data['customer_id'])) {
				Notice::add(Notice::ERROR, __('Already user has this role'));
				if(isset($data['ruid']) && $data['ruid']) {
					$this->_redirect('admin/system_permission_users/edit',array('id' => $data['ruid']));
				} else {
					$this->_redirect('admin/system_permission_users/new');
				}
				return $this;
			}
			
			if($model->checkRoleWebsite(App::instance()->getPlace()->getPlaceId(),$data['customer_id'])) {
				Notice::add(Notice::ERROR, __('Access Denied! Selected user is a owner of this place and have full rights'));
				if(isset($data['ruid']) && $data['ruid']) {
					$this->_redirect('admin/system_permission_users/edit',array('id' => $data['ruid']));
				} else {
					$this->_redirect('admin/system_permission_users/new');
				}
				return $this;
			}
			
			if(isset($data['ruid']) && $data['ruid']) {
				$model->setRuid($data['ruid']);
			}
			$model->setUserId($data['customer_id']);
			$model->setRoleId($data['role_id']);
			$model->setPlaceId(App::instance()->getPlace()->getPlaceId());
			$model->save();
			App::dispatchEvent('Roleusers_Save_After',array('post'=> $data,'roleusers' => $model));
			Notice::add(Notice::SUCCESS, 'Information Updated');
		}

		$this->_redirect('admin/system_permission_users/index');
	}

	public function action_deleterole_users()
	{
		$ruid = $this->getRequest()->query('id');
		$model = App::model('core/role_users')->delete_roleusers($ruid);
		Notice::add(Notice::SUCCESS, __('Role users has been deleted successfully'));
		$this->_redirect('admin/system_permission_users/index');

	}
	
	public function action_storeroleusers()
	{ 
		$this->loadBlocks('system/permission/users/subrolesuser');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Role Users Management'));
		$contentblock->setPageTitle('<i class="fa fa-users" ></i>&nbsp;'.__('Role Users Management'));
		$this->renderBlocks();
	}

} // End Dashboard
