<?php defined('SYSPATH') or die('No direct script access.'); 
class Controller_Login extends Controller_Core_Front {
	
	const USERS_SIGNUP_EMAIL_TEMPLATE = 'USERS_SIGNUP_EMAIL_TEMPLATE';
	const USERS_WELCOME_EMAIL_TEMPLATE = 'USERS_WELCOME_EMAIL_TEMPLATE';
	const USERS_RESET_PASSWORD_EMAIL_TEMPLATE = 'USERS_RESET_PASSWORD_EMAIL_TEMPLATE';
	public function action_index()
	{ 
		$this->_clearOrderSession();
		$query = $this->getRequest()->query();	
		$coresession = App::model('core/session');
		$coresession->setDatas('place_contacts',$query);
		$this->loadBlocks('login');
		$this->getBlock('content')->unsetChild('breadcrumbs');
		$this->getBlock('head')->setTitle(App::getConfig('META_TITLE',Model_Core_Place::ADMIN))
							->setMetaKeywords(App::getConfig('META_KEYWORDS',Model_Core_Place::ADMIN))
							->setMetaDescription(App::getConfig('META_DESCRIPTION',Model_Core_Place::ADMIN));
		$this->renderBlocks(); 
	}
	
	public function action_loginsave()
	{ 
		$request = $this->getRequest();
		$query = $this->getRequest()->query();
		$return = $this->getRequest()->query('return');
		$data = $this->getRequest()->post();
		$post = $this->getRequest()->post();
		$success = false;
		$customermodel = App::model('login');
		$session = App::model('user/session');
		try{
			$validate = $customermodel->validatesignin($data);
			if($customer = $customermodel->userlogin($post)) { 
				$session->generateSession($customer[0]);				
				$session->setDatas('is_owner',$customermodel->checkOwner($customer[0]->getUserId()));
				$session->setDatas('userData',$customer[0]);
				$session->unsetData('form_data');
				$success = true;
			}
		}
		catch(Validation_Exception $ve) {
				$session->setDatas('form_data',$request->post());
				$errors = $ve->array->errors('validation',true);
				$session->setDatas('validation_errors',$errors);
		} catch(Kohana_Exception $ke) {
				Notice::add(Notice::ERROR, __($ke->getMessage()));
		} catch(Exception $e) {
				Notice::add(Notice::ERROR, __($e->getMessage()));
		} 
		if($success){
			Notice::add(Notice::SUCCESS, __('Logged In successfully'));  
			if($return){
				$this->_redirect($return);
			}
			$this->_redirect('',$query);
		}
		$this->_redirect('signin',$query);
		return;
	}
	
	public function action_new()
	{
		$this->auto_render = false;
		$data = json_decode($this->getRequest()->body(),true);
		
		$json = array();
		if(!empty($data) && isset($data['email']) && isset($data['password'])) {
			$customermodel = App::model('user');
			try {
				$customer = $customermodel->login($data);
				if(isset($data['rememberme']) && $data['rememberme']== 1) { 
					Cookie::set('cookie_utoken', $customer->getData('user_token'),604800);
				}
				if(!$customer) {
					throw new Exception(__('Invalid credentials'));
				}
				$user = App::model('user/session');
				/** need email click  url  prams get here  **/
				if($data['type'] && $data['email']==$data['place_email']) {
					$place_acceptance =$customermodel->PlaceUserAcceptance($data,$user->getId());
					if($place_acceptance){
						$coresession = App::model('core/session');
						$coresession->setDatas('place_user_acceptance',false);
						$coresession->unsetData('place_contacts');
						$coresession->generateSession($coresession->getCustomer());	
					}		
				} 
				/** **/
				$session = App::model('user/session');
				$owners = $customer->getOwners($customer->getUserId(),false);
				$json['usertoken'] = $customer->getUserToken();
				if($session->isLoggedIn()) {
					$json['success'] = __('Logged in successfully');
				} else {
					$json['error'] = __('Problem in the server try again later.');
				}
			} catch(Exception $e) {
				/*if($return) {
					$returnurl = array('return_url' => urlencode($return));
				}*/
				$json['error'] = $e->getMessage();
			}
		} else {
			$json['error'] = __('Invalid Email/Password');
		}
		$this->getResponse()->body(json_encode($json));
	}
	
	public function action_facebooklogin()
	{  		
		include_once(DOCROOT . 'includes/facebookapi/src/facebook.php');
		$facebook = new Facebook(array(
					'appId'  => App::getConfig('FACEBOOK_APP_ID',Model_Core_Place::ADMIN),
					'secret' => App::getConfig('FACEBOOK_SECRET_KEY',Model_Core_Place::ADMIN),
		));
		if($this->getRequest()->query('error')){
			$this->redirect('login/access');
		}
		$user = $facebook->getUser();	
		$session = App::model('user/session');
		$session->unsetData();
		$session->setDatas('fbuser',$user);		

		if($user) {
			  try { 
					$user_profile = $facebook->api('/me');
					$user_profile = array_merge(array('type'=>false),$user_profile);
					if(!empty($user_profile)) {
						$exisit_user=App::model('user/attribute_static')->load($user_profile['id'],'value');
						$session->setDatas('fbuser_data',$user_profile);
						if(!$exisit_user->getUserId()){
							$this->emailcheck($user_profile);
							$this->redirect('login/access');
						}else {	
							$session->setDatas('id',$exisit_user->getUserId());	
							$this->redirect('login/access');
						}			
					}
			  } catch (FacebookApiException $e) {
				$user = null;
			  }
		}
		if(!$user) {

			$this->redirect($facebook->getLoginUrl());
		}
	}
	
	public function action_gplusauthorize()
	{ 
		require_once DOCROOT.'includes/google_login_oauth/src/Google_Client.php';
		require_once DOCROOT.'includes/google_login_oauth/src/contrib/Google_Oauth2Service.php';
		$session = App::model('user/session');	
		$client = new Google_Client();
		$client->setApplicationName("street directory");
		$oauth2 = new Google_Oauth2Service($client);
		if($this->getRequest()->query('code')) {
			$client->authenticate($this->getRequest()->query('code'));
			$session->setDatas('token',$client->getAccessToken());	
		}
		if($this->getRequest()->query('error')){
			$this->redirect('login/access');
		}
		if ($client->getAccessToken()) {
			$user = $oauth2->userinfo->get();
					if(!empty($user['id'])) {
						$exisit_user=App::model('user/attribute_static')->load($user['id'],'value');
						$user_profile=array('email'=>$user['email'],'id'=>$user['id'],'gender'=>$user['gender'],'first_name'=>$user['name'],'type'=>true);
						$session = App::model('user/session');	
						$session->setDatas('google_code',$this->getRequest()->query('code'));
						$session->setDatas('fbuser_data',$user_profile);
						if(!$exisit_user->getUserId()){
							$this->emailcheck($user_profile);
							$this->redirect('login/access');
						}else {	
							$session->setDatas('id',$exisit_user->getUserId());	
							$this->redirect('login/access');
						}			
					}
		} else {
			$authUrl = $client->createAuthUrl();
			$this->redirect($authUrl);
		}	
	}
	
	public function emailcheck($data) 
	{ 
		$user = App::model('login');	
		if($data){			
			if (array_key_exists('email', $data)) {	
				if(!empty($data['email'])) {			
					$email = $user->_validateEmailExist($data['email']);
					$session = App::model('user/session');
					$session->setDatas('email_avilable',true);
					if($email) {
						$return=$this->upload_data($data);
						if($return){
							$this->redirect('login/access');
						}		
					}else {
						$customer = App::model('login')->load($data['email'],'primary_email_address');	
						if($data['type']){
							$customer->setData('gplus_profile_id',$data['id']);
						}else{	
							$customer->setData('facebook_profile_id',$data['id']);	
						}
						$customer->saveUser($data);
						/** need email click  url  prams get here  **/
						$coresession = App::model('core/session');
						if(Arr::get($coresession,'place_contacts')) {
						$params = $coresession->getPlaceContacts();
							if($params['type'] && $data['email']==$params['place_email']) {
								$place_acceptance =$customer->PlaceUserAcceptance($data,$customer->getId());
								if($place_acceptance){
									$coresession->setDatas('place_user_acceptance',false);
									$coresession->unsetData('place_contacts');
									$coresession->generateSession($coresession->getCustomer());	
								}		
							} 
						}
						/** **/
						$session->setDatas('user_id',$customer->getUserId());	
						$session->generateSession($customer);
					}		
				}
			}else {		
				$session = App::model('user/session');
				$session->setDatas('email_avilable',false);
				$session->setDatas('need_email_address',true);	
				$session->generateSession($user);	
			}					
		}else{
			$this->redirect('login');	
		}	
	}
	
	public function action_access() 
	{
		$this->auto_render = false;
		$this->loadBlocks('login');
		$contentblock = $this->getBlock('content');
		echo $contentblock->toHtml();
	}	
	
	public function action_email() 
	{ 
		$session = App::model('user/session');
		$user = App::model('login');	
		$this->auto_render = false;
		$data = json_decode($this->getRequest()->body(),true);
		
		$json = array();
		$status="";
		if(!empty($data) && isset($data['email']) && isset($data['passwords'])) {
			$datas=array_merge(App::model('user/session')->getFbuserData(),$data);
			$customermodel = App::model('user');
			try {
				if(!empty($data['email'])) {
					$email = $user->_validateEmailExist($data['email']);
					if($email) {
						$status = $this->upload_data($datas);
					}else {
						//$json['error'] = __('This Email Already exists ');
						throw new Exception(__('This Email Already exists '));
					}	
				}
				if($status) {
					$session->setDatas('need_email_address',false);	
					$json['success'] = __('Logged in successfully');		
				}
				
			} catch(Exception $e) {
				$json['error'] = $e->getMessage(); 
			}
		} else {
			$json['error'] = __('Invalid Email/Password');
		}
		$this->getResponse()->body(json_encode($json));
	}

	public function upload_data($data) 
	{	
		$session = App::model('user/session');
		if(isset($data['gender']) == 'male') {
			$data['gender'] = 'M';
			$data['social_title'] = 'Mr.';
		}else if(isset($data['gender']) == 'female'){
			$data['gender'] = 'F';
			$data['social_title'] = 'Ms.';
		}else {
			$data['gender'] = '';
			$data['social_title'] = '';
		}
		$user = App::model('login');
		if(isset($data['passwords']) && $data['passwords']!='' ){ 
			$password = $data['passwords'];
		}else{		
			$password = Text::random('alnum',8);
		}
		
		if(isset($data['first_name']) && $data['first_name']!='' ){ 
			$first_name = $data['first_name'];
		}else {
			$first_name = '';
		}	
		$user->setData('first_name',$first_name);
		if($data['type']){
			$user->setData('user_login_type',4);
			$user->setData('gplus_profile_id',$data['id']);
		}else{
			$user->setData('user_login_type',3);	
			$user->setData('facebook_profile_id',$data['id']);	
		}	
		$user->setData('social_title',$data['social_title']);
		$user->setData('primary_email_address',$data['email']);
		$user->setData('user_password',$password);
		$user->setData('password',md5($password));
		if (array_key_exists('birthday', $data)) {
			$user->setData('date_of_birth',$data['birthday']);
		}
		$user->setData('gender',$data['gender']);
		$user->setData('created_date',date("Y-m-d H:i:s"));		
		$verification_key = Text::random('alnum',12);
		$user->setVerificationKey($verification_key);
		if($session->getEmailAvilable()){
			$user->setIsVerified(1);
		}	
		$user->saveUser($data);
		/** need email click  url  prams get here  **/
		$coresession = App::model('core/session');
		if(Arr::get($coresession,'place_contacts')) {
			 $params = $coresession->getPlaceContacts();
			if($params['type'] && $data['email']==$params['place_email']) {
				$place_acceptance =App::model('user',false)->PlaceUserAcceptance($data,$user->getId());
				if($place_acceptance){
					$coresession->setDatas('place_user_acceptance',false);
					$coresession->unsetData('place_contacts');
					$coresession->generateSession($coresession->getCustomer());	
				}		
			} 
		}
		/** **/
		$customer = App::model('login')->load($data['email'],'primary_email_address');	
		if($customer->getIsVerified()){
			$session->setDatas('user_id',$customer->getUserId());	
			$session->generateSession($user);	
			$template = App::model('core/email_template')->load(App::getConfig(self::USERS_WELCOME_EMAIL_TEMPLATE,Model_Core_Place::ADMIN));	
		}else{
			$template = App::model('core/email_template')->load(App::getConfig(self::USERS_SIGNUP_EMAIL_TEMPLATE,Model_Core_Place::ADMIN));
			$url1 ='<a href="'.App::getBaseUrl('').'signup/confirmation?key='.$customer->getVerificationKey().'&email='.$customer->getPrimaryEmailAddress().'"> This Confirmation Link </a>';
		}
		$from = $template->getFromEmail();
		$from_name=$template->getFrom();
		$subject = $template->getSubject();
		if(!$template->getTemplateId()) {
			$template = 'mail_template';
			$from=App::getConfig('CONTACT_EMAIL');
			$subject = __("You have created as a user in").App::getConfig('SITE_NAME');
			$from_name="";
		}
		if($customer->getIsVerified()){
			$content = array("customer" => $customer,"first_name" => isset($data['first_name']));
		}else{
			$content = array("customer" => $customer,"first_name" => isset($data['first_name']),"confirmation_link" => $url1);
		}			
		$email=App::model('core/email')->smtp($from,$from_name,$customer->getPrimaryEmailAddress(),$subject,$content,$template);
		return true;
	}
			
	public function action_forget() 
	{ 
		$session = App::model('user/session');
		$query = $this->getRequest()->query();
		$request = $this->getRequest();
		$data = $this->getRequest()->post();
		$user = App::model('login');	
		$json = array();
		$status="";
		$success = false;
		$customermodel = App::model('user');
		try {
				$validate = $user->validateforgetpass($data);
				$secure_key = Encrypt::instance()->encode(Text::random('alnum',15));
				$verification_code=Text::random('nozero',6);
				$customer = App::model('login')->load($data['email'],'primary_email_address');
				$customer->setUserId($customer->getUserId());
				$customer->setPasswordVerificationKey($secure_key);
				$customer->setPasswordVerificationCode($verification_code);
				$customer->setVerificationLinkExpiryStatus(1);
				$customer->save();
				$template = App::model('core/email_template')->load(Model_User::EMAIL_TEMPLATE_FORGET_PASSWORD);
				$url1 ='<a href="'.App::getBaseUrl('').'account/resetpassword?key='.urlencode($secure_key).'"> Click here </a>';
				$from = $template->getFromEmail();
				$from_name=$template->getFrom();
				$subject = $template->getSubject();
				$content = array("customer" => $customer,"reset_passoword_link" => $url1,'code'=>$verification_code);
				$email=App::model('core/email')->smtp($from,$from_name,$customer->getPrimaryEmailAddress(),$subject,$content,$template);	
				$success = true;
				$session->unsetData('form_data');	
		}catch(Validation_Exception $ve) {
			//print_r($ve);exit;
			//Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true));
				$session->setDatas('form_data',$request->post());
				$errors = $ve->array->errors('validation',true);
				$session->setDatas('validation_errors',$errors);
		} catch(Kohana_Exception $ke) {
			//print_r($ke);exit;
				Notice::add(Notice::ERROR, __($ke->getMessage()));
				//Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			//print_r($e);exit;
				Notice::add(Notice::ERROR, __($e->getMessage()));
				//Log::Instance()->add(Log::ERROR, $e);
		} 
		if($success) {
			Notice::add(Notice::SUCCESS, __('New password has been send to your email successfully'));
			$this->_redirect('signin',$query);
		}
		$this->_redirect('login/forgetpassword',$query);
		return $this;
	}
	
	public function action_forgetpassword() 
	{ 
		$this->loadBlocks('login');
		$session = App::model('user/session');	
		$formdata = $session->getData('form_data');
		$session->unsetData('form_data');	
		if($session->getValidationErrors()){
			$this->getBlock('forgetpassword')->setValidationErrors($session->getValidationErrors())->setFormData($formdata);
			$session->unsetData('validation_errors');
		}
		$this->renderBlocks(); 
	}
	
	public function action_logout()
	{ 
		header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
		header('Pragma: no-cache'); // HTTP 1.0.
		header('Expires: 0');
		$session = App::model('user/session');
		$session->logout();
		Cookie::delete('cookie_utoken');
		Notice::add(Notice::ERROR, __('Logged out successfully'));
		$this->redirect('');
	}
	
}
