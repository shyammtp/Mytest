<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_System_Permission_Roles extends Controller_Core_Admin {

	const ROLE_DELETE_USER_EMAIL_TEMPLATE = 'ROLE_DELETE_USER_NOTIFICATION_EMAIL_TEMPLATE';
	public function action_index()
	{
		$this->loadBlocks('system/permission/roles');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Roles Management'));
		$contentblock->setPageTitle('<i class="fa fa-group" ></i>&nbsp;'.__('Roles Management'));
		$this->renderBlocks();
	}

	public function action_ajax()
	{
		$this->loadBlocks('system/permission/roles');
		$output = $this->getBlock('roles_list_grid')->toHtml();
		$this->getResponse()->body($output);
	}

	public function action_new()
	{
		$this->loadBlocks('system/permission/roles/edit');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Roles Management'));
		$contentblock->setPageTitle('<i class="fa fa-group" ></i>&nbsp;'.__('Roles Management'));
		$this->renderBlocks();
	}

	public function action_edit()
	{ 
		$session = App::model('admin/session');
		$this->loadBlocks('system/permission/roles/edit');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Roles Management'));
		$contentblock->setPageTitle('<i class="fa fa-group" ></i>&nbsp;'.__('Roles Management'));
		if($session->getFormData()) {  
			$resources = Arr::get($session->getFormData(),'nodes',array()); 
			$this->getBlock('edit_roles_list_grid')->setDbRoleTasks($resources); 
			$session->unsetData('form_data');
		}
		$this->renderBlocks();
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

	public function action_saverole()
	{ 
		$data = $this->getRequest()->post();
		if(isset($data['role_name']) && $data['role_name']) {
			$model = App::model('core/role');
			$model->setRoleName($data['role_name']);
			$model->setWebsiteId(App::instance()->getWebsite()->getWebsiteId());
			if(App::model('core/customer')->isOwner()) {
				$model->setPlaceId(App::instance()->getPlace()->getPlaceId());
			} else {
				$model->setPlaceId(App::instance()->getPlace()->getPlaceId());
			}
			$model->setFor(Model_Core_Tasks::ADMIN_TASKS);
			$model->setTagBgColor($this->getRequest()->post('tag_bg_color'));
			$model->setCreatedDate(date("Y-m-d H:i:s"));
			$model->setTagTextColor($this->getRequest()->post('tag_text_color'));
			$model->save();
			Notice::add(Notice::SUCCESS, __('Information Updated'));
		} else {
			Notice::add(Notice::ERROR, __('Invalid Information'));
		}
		$this->_redirect('admin/system_permission_roles/index');
	}

	public function action_save()
	{
		$session = App::model('admin/session');
		$resources = $this->getRequest()->post('nodes'); 
		$resdata = $this->getRequest()->post('apires'); 
		$apiresource  =  App::model('core/api',false);		
		$success = false;
		try {
			$taskmodel = App::model('core/tasks');
			$taskmodel->optionTasks();
			$rolemodel = App::model('core/role',false);
			$tasks = $taskmodel->getTaskList();
			$data = $this->getRequest()->post();
			//print_r($data);exit;
			if(!$this->getRequest()->query('id')){
				if(isset($data['role_name']) && $data['role_name']) {
				$model = App::model('core/role');
				$model->setRoleName($data['role_name']);
				$model->setWebsiteId(App::instance()->getWebsite()->getWebsiteId());
				if(App::model('core/customer')->isOwner()) {
					$model->setPlaceId(App::instance()->getPlace()->getPlaceId());
				} else {
					$model->setPlaceId(App::instance()->getPlace()->getPlaceId());
				}
				$model->setFor(Model_Core_Tasks::ADMIN_TASKS);
				$model->setTagBgColor($this->getRequest()->post('tag_bg_color'));
				$model->setCreatedDate(date("Y-m-d H:i:s"));
				$model->setTagTextColor($this->getRequest()->post('tag_text_color'));
				$model->save();
				$roleobject = $rolemodel->load($model->getId());
				$post_role_id = $model->getId();
				} else {
					Notice::add(Notice::ERROR, __('Invalid Information'));
				}
				
			}else{
				$roleobject = $rolemodel->load($this->getRequest()->query('id'));
				$post_role_id = $this->getRequest()->post('role_id');
			}		
			if($roleobject) {
				$apiresource->setRoleId($roleobject->getId());
				$apiresource->load($roleobject->getId(),'role_id');
			}
			if($resdata) { 
				$apiresource->addData($resdata); 
				$apiresource->validate();
			} 
			$set = array();
			$roletask = App::model('core/role_tasks'); 
			$roletask->delete($post_role_id);
			if($roleid = $post_role_id && count($resources)) { 
				$roleobject->setData($this->getRequest()->post())->save();
				foreach($resources as $res) {
					$rs = explode("/",$res);
					$s = '';
					foreach($rs as $r) {
						$s .= $r;
						if(in_array($s,$set)) {
							$s .= "/";
							continue;
						}
						$set[] = $s;  
	
						$s .= "/";
					}
	
				}
			}
			//print_r($set);exit;
			foreach($set as $path) {
				$insert = $roletask->setRoleId($post_role_id)
								->setTaskDefinition($path)
								->setPermission(true);
				if(isset($tasks[$path])) {
					$roletask->setTaskIndex($tasks[$path]);
				}
			
				$roletask->save();
				$roletask->unsetData();
			}
			if(!$apiresource->getAccountId()) {
				$apiresource->setCreatedDate(date("Y-m-d H:i:s",time()));
				$apiresource->unsAccountId();
			}
			$apiresource->setReferencePlaceId(App::instance()->getPlace()->getPlaceId());
			$apiresource->saveApi();
			$success = true;
		} catch(Validation_Exception $ve) {
			$session->setDatas('form_data', $this->getRequest()->post());
			Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true)); 
		} catch(Kohana_Exception $e) {			
 			Notice::add(Notice::ERROR, __('Problem in server, :error',array(":error" => $e->getMessage())));
		} catch(Exception $e) {  
 			Notice::add(Notice::ERROR, __('Problem in server'));
		}
		if($success) {
			Notice::add(Notice::SUCCESS, __('Information Updated'));
			$this->_redirect('admin/system_permission_roles/index');
		}
		$this->_redirect('admin/system_permission_roles/edit',$this->getRequest()->query());		  
	}
	
	public function action_deleterole()
	{ 
		$roleid=$this->getRequest()->query('id');
		$t = $this->getRequest()->query('_t');
		$role = App::model('core/role')->load($roleid);
		$model = App::model('core/role_users');
		if(!$t) {
			$roles = $model->getRoleusers($role->getId()); 
			foreach($roles as $r) {
				$customer = App::model('user',false)->load($r->user_id);
				$place = App::model('core/place')->getPlaceInfo($r->place_id);
				if(!$customer->getId()) {
					continue;
				} 
				$role->setPlaceName($place->getPlaceName());
				$template = App::model('core/email_template')->load(App::getConfig(self::ROLE_DELETE_USER_EMAIL_TEMPLATE,Model_Core_Place::ADMIN));
				$from = $template->getFromEmail();
				$from_name=$template->getFrom();
				$subject = $template->getSubject();
				if($template->getTemplateId()) { 
					$content =array("role"=>$role,"customer" => $customer);
					$email=App::model('core/email')->smtp($from,$from_name,$customer->getPrimaryEmailAddress(),$subject,$content,$template);
				}
				 
			} 
		}
		$model = App::model('core/role')->delete_role($roleid);
		Notice::add(Notice::SUCCESS, __('Role has been deleted successfully'));
		$this->_redirect('admin/system_permission_roles/index');
	
	}
	
	public function action_storeroles()
	{ 
		$this->loadBlocks('system/permission/roles/subroles');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Roles Management'));
		$contentblock->setPageTitle('<i class="fa fa-group" ></i>&nbsp;'.__('Roles Management'));
		$this->renderBlocks();
	}
	
	
} // End Dashboard
