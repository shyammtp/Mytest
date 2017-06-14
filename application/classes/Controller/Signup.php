<?php defined('SYSPATH') or die('No direct script access.');  
/*
    * @Front End Signup Controller
*/
class Controller_Signup extends Controller_Core_Front {
	
	const USERS_SIGNUP_EMAIL_TEMPLATE = 8;
	const USERS_WELCOME_EMAIL_TEMPLATE = 9;
	
	public function action_index()
	{
		$this->loadBlocks('signup');
		 		
		$type = $this->getRequest()->query('type'); 		
		$this->renderBlocks();
	}
	
	public function action_save()
    { 
		$session = App::model('user/session');
		$this->auto_render = false;
		$request = $this->getRequest();
		$data = $request->post();
		$success = false;
		$errors = array();
		$query = $this->getRequest()->query();
		if($this->getRequest()->query('return_url')) {
			$query['return_url'] = urldecode($this->getRequest()->query('return_url'));
		}
		try {
			$customermodel = App::model('user');
			$validate = $customermodel->validatesignup($data);
			$customermodel->setData($data);	
			$user = App::model('login',false);
			$user->setStatus(1);
			$user->setCreatedDate(date("Y-m-d H:i:s"));
			$user->setUpdatedDate(date("Y-m-d H:i:s"));
			$user->setPassword(md5($data['password']));
			$user->setPrimaryEmailAddress($data['email']);
			$verification_key = Text::random('alnum',12);
			$user->setUserLoginType(2);
			$user->setUserType($data['usertype']);
			$user->setVerificationKey($verification_key);
			$user->setMobile($data['mobile']);	
			$user->setFirstName($data['first_name']);	
			$user->saveUser($data);
			$success = true;
			$session->unsetData('form_data');
			
		}
		catch(Validation_Exception $ve) {
		
				$session->setDatas('form_data',$request->post());
				//Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true));
				$errors = $ve->array->errors('validation',true);
				//print_r($errors); exit;
				$session->setDatas('validation_errors',$errors);
		} catch(Kohana_Exception $ke) {
			//print_r($ke);exit;
				Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$ke->getMessage())));
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			//print_r($e);exit;
				Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$e->getMessage())));
		Log::Instance()->add(Log::ERROR, $e);
		}
		
		if($success) {
			$customer = App::model('login')->load($data['email'],'primary_email_address');					
			$template = App::model('core/email_template')->load(self::USERS_SIGNUP_EMAIL_TEMPLATE);					
			$from = $template->getFromEmail();
			$from_name=$template->getFrom();
			$subject = $template->getSubject();
			if(!$template->getTemplateId()) {
				$template = 'mail_template';
				$from=App::getConfig('CONTACT_EMAIL');
				$subject = __("You are now user of ").App::getConfig('SITE_NAME');
				$from_name="";
			}			
			$url1 ='<a href="'.App::getBaseUrl('').'signup/confirmation?key='.$customer->getVerificationKey().'&email='.$customer->getPrimaryEmailAddress().'&u_password='.$data['password'].'"> This Confirmation Link </a>';
			$content = array("customer" => $customer,"first_name" => $data['first_name'], "confirmation_link" => $url1);		
			$email=App::model('core/email')->smtp($from,$from_name,$customer->getPrimaryEmailAddress(),$subject,$content,$template); 
			$session->setDatas('session_form_data',$request->post());
			Notice::add(Notice::SUCCESS, __('Registration proccess has been completed successfully'));
			$this->_redirect('signup',$query);
			return $this;
		}
		if($data['usertype'] == 1){
			$this->_redirect('signup/doctor',$query);
		}else{
			$this->_redirect('signup',$query);
		}
		return $this;
		
    }
    
    public function action_resendEmail()
    { 
		$session = App::model('user/session');
		$sess_data = $session->getData('session_form_data');
		$sess_count = $session->getData('session_email_count');
		$this->auto_render = false;
		$errors = array();
		$customer = App::model('login')->load($sess_data['email'],'primary_email_address');			
		$template = App::model('core/email_template')->load(self::USERS_SIGNUP_EMAIL_TEMPLATE);					
		$from = $template->getFromEmail();
		$from_name=$template->getFrom();
		$subject = $template->getSubject();
		if(!$template->getTemplateId()) {
			$template = 'mail_template';
			$from=App::getConfig('CONTACT_EMAIL');
			$subject = __("You have created as a user in").App::getConfig('SITE_NAME');
			$from_name="";
		}			
		$url1 ='<a href="'.App::getBaseUrl('').'signup/confirmation?key='.$customer->getVerificationKey().'&email='.$customer->getPrimaryEmailAddress().'&u_password='.$sess_data['password'].'"> This Confirmation Link </a>';
		$content = array("customer" => $customer,"first_name" => $sess_data['first_name'], "confirmation_link" => $url1);		
		$email=App::model('core/email')->smtp($from,$from_name,$customer->getPrimaryEmailAddress(),$subject,$content,$template); 
		if(!$sess_count){
			$i = 1;
			//*** If you want multiple resend comment '$session->unsetData()' and uncomment '$session->setDatas('session_email_count',$i)' ****/
			$session->unsetData();
			//$session->setDatas('session_email_count',$i);
		}else{
			if($sess_count < 2){
				$sess_count++;
				$i = $sess_count;
				$session->setDatas('session_email_count',$i);
			}else{
				$session->unsetData();
			}
		}
		Notice::add(Notice::SUCCESS, __('Confirmation email resent successfully'));
		$this->_redirect('signup');
		return $this;
		
    }
    
    public function action_confirmation()
	{ 
		$success = false;
		$errors = array();
		$query = $this->getRequest()->query();	
		
		if((isset($query['key']) && $query['key']) && (isset($query['email']) && $query['email'])){
			$customer = App::model('login')->_emailConfirmation($query['key'],$query['email']);
			try {
				if($customer){
					$verified=App::model('login')->_isVerification($query['key'],$query['email']);
					
					if($verified){
						$user =App::model('login')->load($query['email'],'primary_email_address');
						$user->setUserId($user->getUserId());
						$user->setIsVerified(1);
						$user->save();
						$template = App::model('core/email_template')->load(self::USERS_WELCOME_EMAIL_TEMPLATE);
						$from = $template->getFromEmail();
						$from_name=$template->getFrom();
						$subject = $template->getSubject();
						if(!$template->getTemplateId()){
							$template = 'mail_template';
							$from=App::getConfig('CONTACT_EMAIL');
							$subject = __("Welcome to ").App::getConfig('SITE_NAME');
							$from_name="";
						}
						$content =array("customer" => $user,'u_password' => $this->getRequest()->query('u_password'));
						$email=App::model('core/email')->smtp($from,$from_name,$user->getPrimaryEmailAddress(),$subject,$content,$template);
						$settings=App::getConfig('USER_SETTINGS',Model_Core_Place::ADMIN);
						if($settings){
							$session = App::model('user/session');
							$session->setDatas('id',$user->getId());	
							$session->generateSession($user);
							$success = true;
						}
					}else { 
						Notice::add(Notice::ERROR, __('Email alredy verified'));
						$errors = true;
						print(__('Email alredy verified')); 
					}

				}else { 
					//Notice::add(Notice::ERROR, __('Invalid key or email'));
					$errors = true;
					print(__('Invalid key or email'));
				}
		}catch(Kohana_Exception $ke) {
			Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$ke->getMessage())));
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$e->getMessage())));
			Log::Instance()->add(Log::ERROR, $e);
		}
		$this->redirect('account/welcome');
		}else {
			Notice::add(Notice::ERROR, __('Invalid key or email'));
			print(__('Invalid key or email')); 
			$this->_redirect('/');	
		}
		
	}
	
	public function action_emailconfirmation()
	{ 
		$success = false;
		$errors = array();
		$query = $this->getRequest()->query();	
		if((isset($query['email']) && $query['email']) && (isset($query['id']) && $query['id']) ){
			try {
				$user =App::model('login')->load($query['id']);
				if(count($user)){
					if($user->getEmailConfirmationStatus()){
							$user->setUserId($user->getUserId());
							$user->setEmailConfirmationStatus(false);
							$user->setPrimaryEmailAddress($user->getConfirmEmail());
							$user->save();
					}else { 
							Notice::add(Notice::ERROR, __('Email alredy verified'));
							$errors = true;
							print(__('Email alredy verified')); 
							exit;
					}
				}else { 
					Notice::add(Notice::ERROR, __('Invalid id or email'));
					$errors = true;
					print(__('Invalid id or email'));
				}
		}catch(Kohana_Exception $ke) {
			Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$ke->getMessage())));
			Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$e->getMessage())));
			Log::Instance()->add(Log::ERROR, $e);
		}
		$this->redirect('account/welcome');
		}else {
			Notice::add(Notice::ERROR, __('Invalid id or email'));
			print(__('Invalid id or email')); 
			$this->_redirect('/');	
		}
	}
	
	public function action_emailcheck()
	{
		$user = App::model('login');
		$data = $this->getRequest()->post();
		$email = $user->_validateEmailExist($data['email']);
		$this->getResponse()->body($email);
	}  
} 
