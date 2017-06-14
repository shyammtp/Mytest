<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Index extends Controller_Core_Admin {

	const ADMIN_FORGOT_PASSWORD_EMAIL_TEMPLATE = 'ADMIN_FORGOT_PASSWORD_EMAIL_TEMPLATE';
	public function preDispatch()
    {
		$this->_openactions = array('login','postlogin','logout','forgot','postforgotpassword','clearfilecache');
		$this->_noAccessCheckAction = array('login','postlogin','logout','forgot','postforgotpassword');
		parent::preDispatch();
	}
	public function action_index()
	{ 
		 $this->forward('move');
	}

	public function action_set()
	{
		$this->page404();
	}

	public function action_login()
	{ 
		$this->getRequest()->headers('Cache-Control','no-cache, no-store, must-revalidate');
		if(App::model('admin_session')->isLoggedIn()){
			$this->_redirect('admin/dashboard/index');
			return;
		}			
		$block = $this->loadBlocks('login');
		$pagetitle = __('Login');
		$this->getBlock('head')->setTitle(__('Login'));
		$this->getBlock('content')
				->unsetChild('header')
				->unsetChild('footer');
		$this->renderBlocks();
	}

	public function action_logout()
	{
		$this->getRequest()->headers('Cache-Control',' no-cache, no-store, must-revalidate'); 
		$session = App::model('admin_session');
		$session->logout();
		Notice::add(Notice::ERROR, __('Logged out successfully'));
		$this->_redirect('admin/index/login');
	}

	public function action_postlogin()
	{
		$return = trim($this->getRequest()->post('return_url'),"/");
		$returnparams = json_decode(base64_decode($this->getRequest()->post('return_query_param')),true);
		if($returnparams) {
			//$return.= URL::query($returnparams);
		} 
		if(!$return) {
			$return = 'admin/dashboard/index';
		} 
		$query = array();
		$post = $this->getRequest()->post();
		$customermodel = App::model('user');
		if(isset($post['email']) && isset($post['password'])) {
			
			if($customer = $customermodel->adminlogin($post)) { 
				$session = App::model('admin_session');
				//$session->setDatas('roles',$customer->getCustomerRoles()); 
				$session->generateSession($customer);				
				$session->setDatas('is_owner',$customermodel->checkOwner($customer->getUserId()));
				Notice::add(Notice::SUCCESS, __('Logged In successfully')); 				
				$this->_redirect($return,$returnparams);
			} else {
				if($return) {
					$query['return_url'] =  urlencode($return);
				}
				if($this->getRequest()->query('_stl')) {
					$query['_stl'] = $this->getRequest()->query('_stl');
				}
				$session = App::model('admin_session');
				$session->setDatas('form-data',$post);
				Notice::add(Notice::ERROR, 'Invalid Email/Password');
				$this->_redirect('admin/index/login',$query);
				return;
			}
		}
		$session = App::model('admin_session');
		$session->setDatas('form-data',$post);
		Notice::add(Notice::ERROR, 'Invalid Email/Password');
		$this->_redirect($return,$returnparams);
		return;
	}

	public function action_forgot()
	{		
		if(App::model('admin_session')->isLoggedIn()){
			$this->_redirect('admin/dashboard/index');
			return;
		}
		$block = $this->loadBlocks('forgotpass');
		$this->getBlock('head')->setTitle(__('Forgot Password'));
		$this->getBlock('content')
				->unsetChild('header')
				->unsetChild('footer');
		$this->renderBlocks();

	}

	public function action_postforgotpassword()
	{
		$return = trim($this->getRequest()->post('return_url'),"/");
		//print_r($return);exit;
		$post = $this->getRequest()->post();
		if(isset($post['email'])) {
			$customermodel = App::model('user');
			$validate=$customermodel->checkEmailValidate($post);
			if($validate->check()) {
				$customer=$customermodel->load($post['email'],'primary_email_address');
				$template = App::model('core/email_template')->load(App::getConfig(self::ADMIN_FORGOT_PASSWORD_EMAIL_TEMPLATE));
				$from = $template->getFromEmail();
				$from_name=$template->getFrom();
				$subject = $template->getSubject();
				if(!$template->getTemplateId()) {
					$template = 'mail_template';
					$from=App::getConfig('CONTACT_EMAIL');
					$subject = __("Forgot Password");
					$from_name="";
				} 
				$password = Text::random($type = 'alnum', $length = 8);
				$content = array("customer" => $customer,"password" => $password,"name" => $customer->getFirstName());
				$email=App::model('core/email')->smtp($from,$from_name,$customer->getPrimaryEmailAddress(),$subject,$content,$template);
				$customermodel->setUserId($customer->getUserId());
				$customermodel->setPassword(md5($password));
				$customermodel->save();
				Notice::add(Notice::SUCCESS, __('Password reset successfully check your email'));	
			} else {
				Notice::add(Notice::ERROR, 'Validation failed:', NULL, $validate->errors('validate/forgotpass'));
				$this->_addErrors($validate->errors('validate/forgotpass'));
				if($return) {
					$returnurl = array('return_url' => urlencode($return));
				}
				//$this->_redirect($return);
				$this->_redirect('admin/index/forget');
				return;
			}
		}
		$this->_redirect('admin/index/forget');
		//$this->_redirect($return);
		return;
	} 
	
	public function action_switch()
	{
		$user = App::model('admin/session')->getCustomer();
		$request = $this->getRequest(); 
		$website = App::model('core/website')->load($request->query('website_id'));
		if($website->getWebUrl()) {
			$url = $website->getWebUrl();
			$query = url::query(array('email' => $user->getPrimaryEmailAddress(),'type' => 'admin'));
			$queryset = url::query(array('email' => $user->getPrimaryEmailAddress(),'panel' => $request->query('place_id'),'type' => 'owner','_owid' => $request->query('owid')));
			$enc = base64_encode(Encrypt::instance()->encode(trim($queryset,"?")));
			$url .= $query."&_stl=".$enc; 
			$this->_redirectUrl($url);
		}
	}
	
	
	public function action_clearfilecache()
	{
		$user = App::model('user')->isOwner();
		$cache = App::model('core/cache',false);
		$this->auto_render = false;
		if(!$user) {
			Notice::add(Notice::ERROR,__('Access Denied. Contact Your adminstrator.'));
			$this->_redirect('admin/settings/general');
		}
		$request = $this->getRequest();
		if($request->query('_sl') == '_sham') { 
			if($request->query('_k') == '_clear') {
				$cache->clearAllCache();
				Notice::add(Notice::SUCCESS,__('All Caches has been cleared successfully'));
			} else {
				$cache->cleargarbage();
				Notice::add(Notice::SUCCESS,__('Expired Cache has been cleared successfully')); 
			}
		}
		if($request->query('_sl') =='indi') {
			$type = $request->query('type');
			App::model('core/cache_key')->clearCacheByType($type);
			Notice::add(Notice::SUCCESS,__(':type Cache has been cleared successfully',array(':type' => $type)));
		}
		$this->_redirect('admin/settings/cache');
	}

}
