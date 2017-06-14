<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Store_Index extends Controller_Core_Store {

	const CHOOSE_AN_PLACE = 10008;
	public function preDispatch()
    {
		$this->_openactions = array('login','postlogin','logout','renderimage','chooseplace','switch');
		$this->_noAccessCheckAction = array('login','postlogin','choosestore','assignstore','renderimage','chooseplace','logout','switch');
		$this->_nonsubscriptionactions = array('index','login','postlogin','choosestore','assignstore','renderimage','chooseplace','logout','switch');
		
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
		if(App::model('store/session')->isLoggedIn()){
			$this->_redirect('admin/dashboard/index');
			return;
		}
		$block = $this->loadBlocks('login');
		if($panel = App::helper('url')->getSwitchAccountDatas()->getPanel()) {
			$place = App::model('core/place')->load($panel);
			App::setCurrentStore($place->getPlaceIndex());
		}
		$this->getBlock('content')
				->unsetChild('header')
				->unsetChild('leftmenu')
				->unsetChild('footer');
		$this->renderBlocks();

	}
	
	private function _logout()
	{
		$session = App::model('store/session');
		App::dispatchEvent('Store_Admin_Logout_Before',array('session' => $session));
		$session->logout();
		App::dispatchEvent('Store_Admin_Logout_After',array('session' => $session));
	}
	
	private function _login($post)
	{
		$customermodel = App::model('user');
		$customer = $customermodel->storelogin($post);
		if(!$customer) {
			throw new Exception(__('Invalid credentials'));
		}
		$place = App::model('core/place');
		if(isset($post['panel'])) {
			$place->load($post['panel']);
		} 
		App::setCurrentStore($place->getPlaceIndex() ? $place->getPlaceIndex() : App::instance()->getPlace()->getPlaceIndex());
		if(!$place->getPlaceId()) { 
			if(count($customer->getAdminPlaces()) > 1) {
				throw new Kohana_Exception(__('Choose a place'),NULL,10008); 
			} else if(count($customer->getAdminPlaces()) == 1) {
				$set = $customer->getAdminPlaces();						
				$place->load(key($set)); 
				App::setCurrentStore($place->getPlaceIndex() ? $place->getPlaceIndex() : App::instance()->getPlace()->getPlaceIndex());
			}
		} 
		$ownerset = $customermodel->getOwners($customer->getId()); 
		$session = App::model('store/session'); 
		$session->setDatas('roles',$customer->checkOnAdminRoles()->getCustomerRoles());
		$session->generateSession($customer->getCustomer());
		App::dispatchEvent('Store_Admin_Login_After',array('role' => $customer, 'customer' => $customermodel, 'session' => $session));
		return true;
		
	}

	public function action_logout()
	{ 
		$this->_logout();
		Notice::add(Notice::SUCCESS, 'Logged Out Successfully');		
		$this->_redirect('store/index/login');
	}
	 

	public function action_postlogin()
	{

		$success = false;
		$return = 'store/dashboard/index';
		$post = $this->getRequest()->post(); 
		$customermodel = App::model('user');
		try {
			$validate = $customermodel->loginValidate($post);
			$session = App::model('store_session');
			$session->unsetData('form_data');
		}catch(Validation_Exception $e) {
			$session = App::model('store_session');
			$session->setDatas('form-data',$post);
			Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $e->array->errors('validation',true));
			$errors = $e->array->errors('validation',true);
			$this->_redirect('store/index/login');
			return;
		}		
		if(isset($post['email']) && isset($post['password'])) {
			try { 				

				$customer = $customermodel->storelogin($post);
				if(!$customer) { 
					throw new Exception(__('Invalid credentials'));
				}
				$place = App::model('core/place');
				$website_cus = App::model('core/customer/website')->load($customer->getUserId(),'owner_id'); 
				$place_entity = App::model('core/place',false)->load($website_cus->getPlaceId());  
				App::setCurrentStore($place->getPlaceIndex() ? $place->getPlaceIndex() : App::instance()->getPlace()->getPlaceIndex());
				
				$session = App::model('store/session'); 
				$session->setDatas('insurance_id',$place_entity->getEntityPrimaryId());
				$session->setDatas('place_id',$website_cus->getPlaceId());
				$session->generateSession($customer);
				App::dispatchEvent('Store_Admin_Login_After',array('role' => $customer, 'customer' => $customer, 'session' => $session));
				Notice::add(Notice::SUCCESS, 'Logged In successfully');
				$success = true;
			} catch(Kohana_Exception $e) { 
				print_r($e);exit;
				switch($e->getCode()) {
					case self::CHOOSE_AN_PLACE:
						$this->_redirect('index/chooseplace',array('s'=> Encrypt::instance()->encode($customer->getUserId()),'s_rd' => Encrypt::instance()->encode(implode("-",$customer->getAdminPlaces())),'_tir' => Encrypt::instance()->encode($post['password'])));
						return;
					break;
				}
			} catch(Exception $e) { 
				print_r($e);exit;
				if($return) {
					$returnurl = array('return_url' => urlencode($return));
				}
				Notice::add(Notice::ERROR, 'Invalid Email/Password');
				$this->_redirect('login.html',$returnurl);
				return;
			}
			if($success) { 
				$this->_redirect($return);
			}
			$this->_redirect($return);
		} 
		$session = App::model('store_session');
		$session->setDatas('form-data',$post);
		Notice::add(Notice::ERROR, 'Invalid Email/Password');
		$this->_redirect($return);
		return;
	}
	 

	public function action_chooseplace()
	{ 
		if(App::model('store_session')->isLoggedIn()){
			$this->_redirect('admin/dashboard/index');
			return;
		}
		$this->loadBlocks('login');
		$request = $this->getRequest();
		$customer = App::model('user',false)->load(Encrypt::instance()->decode($request->query('s')));
		$rolemodel = App::model('core/role')->setCustomer($customer)->checkOnAdminRoles(); 
		$this->getBlock('content')
				->unsetChild('header')
				->unsetChild('leftmenu')
				->unsetChild('footer');
		$this->getBlock('loginform')->setChoosePlace(true)->setRoleModel($rolemodel);
		$this->renderBlocks();
	}

	public function action_assignstore()
	{
		$return = trim($this->getRequest()->post('return_url'),"/");
		if(!$return) {
			$return = 'admin/dashboard.do';
		}
		App::setCurrentStore($this->getRequest()->query('store'));
		$this->_redirect(App::model('core/customer')->getRedirect($return),array('___store' => $this->getRequest()->query('store')));
	}

	public function action_renderimage()
	{
		$this->auto_render = FALSE;
		$image = $this->getRequest()->query('image');
        $image = new Kohana_Core_Imagecache($image);
        $image->output_file();
	}
	
	public function action_switch()
	{ 
		$request = $this->getRequest();		
		if($request->query('destroy')) {
			$this->_logout();
		}
		$user = App::model('user')->load($request->query('auth_user'),'user_token');
		$website = App::model('core/website')->load($request->query('website_id'));
		if($website->getWebUrl()) {
			$url = $website->getWebUrl();
			$query = url::query(array('email' => $user->getPrimaryEmailAddress(),'type' => 'admin'),false);
			$queryset = url::query(array('email' => $user->getPrimaryEmailAddress(),'panel' => $request->query('place_id'),'type' => 'owner','_owid' => $request->query('owid')),false);
			$enc = base64_encode(Encrypt::instance()->encode(trim($queryset,"?")));
			$url .= $query."&_stl=".$enc; 
			$this->_redirectUrl($url);
		}
	}

}
