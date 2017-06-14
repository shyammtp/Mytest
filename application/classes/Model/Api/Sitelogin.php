<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Database Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Api_Sitelogin extends Model_RestAPI {
	
	const USERS_SIGNUP_EMAIL_TEMPLATE = 'USERS_SIGNUP_EMAIL_TEMPLATE';
	const USERS_WELCOME_EMAIL_TEMPLATE = 'USERS_WELCOME_EMAIL_TEMPLATE';
	const USERS_RESET_PASSWORD_EMAIL_TEMPLATE = 'USERS_RESET_PASSWORD_EMAIL_TEMPLATE';
		
	public function __construct()
	{ 
		$this->_model = App::model('login');		
	}	
	
	public function sitelogin($params)
	{
		$this->auto_render = false;
		$data = $params;
		
		$json = array();
		if(!empty($data) && isset($data['email']) && isset($data['password'])) {
			$customermodel = App::model('user');
			try {
				$customermodel->setData($data);
				$validate = $customermodel->validateFrontEndLogin();
				$customer = $customermodel->login($data);
				if(isset($data['rememberme']) && $data['rememberme']== 1) { 
					Cookie::set('cookie_utoken', $customer->getData('user_token'),604800);
				}
				if(!$customer) {
					throw new Exception(__('Invalid credentials'));
				}					
				$session = App::model('user/session');
				//$owners = $customer->getOwners($customer->getUserId(),false);
				$json['userinfo'] = $customer->getData();
				$json['success'] = __('Logged in successfully');
				/*						
				if($session->isLoggedIn()) {
					$json['success'] = __('Logged in successfully');
				} else {
					$json['error'] = __('Problem in the server try again later.');
				}
				*/
			} catch(Validation_Exception $ve) { 
				$errors = $ve->array->errors('validation',true); 
				$json['errors'] = $errors; 
			} catch(Exception $e) {				
				$json['error'] = $e->getMessage();
			}
		} else {
			$json['error'] = __('Invalid Email/Password');
		}
		return array('details' => $json);		
	}	
	
	public function sociallogin($params)
	{ 
		 if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing Profile Id'),
				'field' => 'id',
			));
			$data['success'] = false;
		}
		 if($params['user_login_type'] == 4) {
			 $type = true;
		 } else {
			 $type = false;
		 }	
		 $userdata = array();	 
		 $json = array();	
		  try { 				
			$user_profile = array_merge(array('type'=>$type),$params);			
			if(!empty($user_profile)) {
				$exisit_user=App::model('user/attribute_static')->load($user_profile['id'],'value');							
				if(!$exisit_user->getUserId()){
					$json['userinfo'] = $this->emailcheck($user_profile);															
				} else {					
					if(!empty($user_profile) && isset($user_profile['email'])) {
						$customermodel = App::model('user');
						try {						
							$customer = $customermodel->login($user_profile);	
													
							if(isset($user_profile['rememberme']) && $user_profile['rememberme']== 1) { 
								Cookie::set('cookie_utoken', $customer->getData('user_token'),604800);
							}
							if(!$customer) {
								throw new Exception(__('Invalid credentials'));
							}					
							$session = App::model('user/session');
							$owners = $customer->getOwners($customer->getUserId(),false);
							$json['userinfo'] = $customer->getData();
							if($session->isLoggedIn()) {
								$json['success'] = __('Logged in successfully');
							} else {
								$json['error'] = __('Problem in the server try again later.');
							}
						} catch(Exception $e) {				
							$json['error'] = $e->getMessage();
						}
					}	
				}		
			}
		  } catch (FacebookApiException $e) {
				$user = null;
		  }	
		  return array('details' => $json);
	}
	
	public function emailcheck($data) 
	{ 
		$userdata = array();
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
							//$this->redirect('login/access');
						}		
					}else {
						$customer = App::model('login')->load($data['email'],'primary_email_address');	
						
						if($data['type']){
							$customer->setData('gplus_profile_id',$data['id']);
						}else{	
							$customer->setData('facebook_profile_id',$data['id']);	
						}
						$customer->saveUser($data);
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
			//$this->redirect('login');	
		}	
		$customerdata = App::model('user')->load($data['email'],'primary_email_address');
		$userdata = $customerdata->getData();					
		return $userdata;
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
			$datas=array_merge($data,App::model('user/session')->getFbuserData());
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
		if(isset($data['gender'])) {
			if($data['gender'] == 'male') {
				$data['gender'] = 'M';
				$data['social_title'] = 'Mr.';
			} else {
				$data['gender'] = 'F';
				$data['social_title'] = 'Ms.';
			}
		} else {
			$data['gender'] = 'M';
			$data['social_title'] = 'Mr.';
		}
		$user = App::model('login');
		$password = Text::random('alnum',8);
		
		$user->setData('first_name',$data['fullname']);
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
						
}	
