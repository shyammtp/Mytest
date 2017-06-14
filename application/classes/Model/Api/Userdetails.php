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
class Model_Api_Userdetails extends Model_RestAPI {
	
	protected $_allowedFields = array('user_id','social_title','user_first_name','user_middle_name','user_family_name','primary_email_address','date_of_birth','gender','profile_image','language_id','nationality','status','created_date','updated_date','user_profession_id','user_group_id','first_name','facebook_page');
	const USERS_RESET_PASSWORD_EMAIL_TEMPLATE = 'USERS_RESET_PASSWORD_EMAIL_TEMPLATE';
	const EMAIL_TEMPLATE_FORGET_PASSWORD = 2;
	const CONTACTUS_EMAIL_TEMPLATE = 3;
	const CONTACTUS_ADMIN_EMAIL_TEMPLATE = 5;
	public function __construct()
	{ 
		$this->_model = App::model('user');
	}
	
	public function getQueryData()
	{ 
		$select = $this->_model->setLanguage(App::getCurrentLanguageId())->selectAttributes($this->_fields);
		return $select; 
	}
	
	public function get($params)
	{ 
		$id=(int)Request::current()->param('param');
		$this->_params = $params; 
		$user=$this->_model->load($id);	
		$city =array();
		if($user->getUserId()){
			$resultant = $user->getData();
			$profileimage = $user->getProfileImageUrl(200,200);
			$profileimage = ($profileimage) ? $profileimage : App::getBaseUrl().'/assets/front/base/images/default_avatar_male.jpg';			
			$resultant['profile_image'] = $profileimage;
			$primary =array();
			if(count($user->getAllContactDetails()) > 0) { 
				foreach($user->getAllContactDetails() as $key => $value){
					if($value['is_primary']){
						$primary[] = $value;
					}					
				}
			}
			$resultant['primary_mobile'] = $primary;
			$resultant['email_notification'] = $user->getConfig("EMAIL_APP_NOTIFICATION");
			$resultant['appointment_accept'] = $user->getConfig("APPOINTMENT_ACCEPT");
			$resultant['contact_details'] = $user->getAllContactDetails();
			$resultant['email_details'] = $user->getAllEmailDetails();
			$resultant['profilepersentage'] = $user->profiledata($user->getData());
			$citymodel = App::model('location/city')->getCityById($resultant['resident_location'],$resultant['language_id']);
			if($citymodel){
				$city['resident_location'] = $citymodel->getCityName();
				$resultant = array_merge($resultant,$city);
			}
			if(isset($params['single'])) {
				return $resultant;
			}
			
			$this->_totalItems = 1;
		}else{ 	
			$this->_prepareList(); 
			$resultant = $this->as_array();
		}
		
		unset($resultant['password'],$resultant['verification_key'],$resultant['password_verification_code'],$resultant['password_verification_key']); 
		return array('details' => $resultant,'total_rows' => $this->_totalItems);
	}
	
	public function getProfiles($params)
	{ 
		//$id=(int)Request::current()->param('param');
		$this->_params = $params; 
		$user=$this->_model->setLanguage(App::getCurrentLanguageId())->load($params['id']);	
		$city =array();
		if($user->getUserId()){
			$resultant = $user->getData();
			$profileimage = $user->getProfileImageUrl('w200','h200');
			$profileimage = ($profileimage) ? $profileimage : App::getBaseUrl().'/assets/front/base/images/default_avatar_male.jpg';			
			$resultant['profile_image'] = $profileimage;
			$primary =array();
			if(count($user->getAllContactDetails()) > 0) { 
				foreach($user->getAllContactDetails() as $key => $value){
					if($value['is_primary']){
						$primary[] = $value;
					}					
				}
			}
			$resultant['primary_mobile'] = $primary;			
			$resultant['email_notification'] = $user->getConfig("EMAIL_APP_NOTIFICATION");
			$resultant['appointment_accept'] = $user->getConfig("APPOINTMENT_ACCEPT");
			$resultant['contact_details'] = $user->getAllContactDetails();
			$resultant['email_details'] = $user->getAllEmailDetails();
			$resultant['profilepersentage'] = $user->profiledata($user->getData());
			//~ $citymodel = App::model('location/city')->getCityById($resultant['resident_location'],$resultant['language_id']);
			//~ if($citymodel){
				//~ $city['resident_location'] = $citymodel->getCityName();
				//~ $resultant = array_merge($resultant,$city);
			//~ }
			$country_arr = array();
			if($user->getCountry()){
				$country = App::model('core/country')->load($user->getCountry());
				$country_arr[] =  $country->getData();
			}
			$city_arr = array();
			if($user->getCity()){
				$city = App::model('core/city')->load($user->getCity());
				$city_arr[] =  $city->getData();
			}
			$area_arr = array();
			if($user->getArea()){
				$area = App::model('core/area')->load($user->getArea());
				$area_arr[] =  $area->getData();
			}
			
			
			$dep_lists = $user->getDepartments();
			$insurance_lists = $user->getInsurance();
			$Clinic_lists = $user->getClinics();
			
			
			$dep_arr = array();
			foreach($dep_lists as $depIds){
				$dep_arr[] = $depIds->getData();
			}
			
			$insurance_arr = array();
			foreach($insurance_lists as $insIds){
				$insurance_arr[] = $insIds->getData();
			}
			$Clinic_arr = array();
			foreach ($Clinic_lists as $clinicIds) {
				$Clinic_arr[] = $clinicIds->getData();
			}
			
			
			if(isset($params['single'])) {
				return $resultant;
			}
			$this->_totalItems = 1;
		}else{ 	
			$this->_prepareList(); 
			$resultant = $this->as_array();
		}
		
		
		unset($resultant['password'],$resultant['verification_key'],$resultant['password_verification_code'],$resultant['password_verification_key']); 
		return array('details' => $resultant,'departments' => $dep_arr,'insurance' => $insurance_arr,'clinics' => $Clinic_arr,'country' => $country_arr,'city' => $city_arr,'area' => $area_arr);
	}
	
	public function action_getdepartmentlists()
	{
		$dep_lists = App::model('core/department')->getDepartment($this->getRequest()->query('q'));
		$this->getResponse()->body(json_encode($dep_lists));
	}
	
	public function create($params)
	{
		$data = array();
		$customermodel = clone $this->_model;
		try{
			$validateCustomer = $customermodel->validate($params);
			$customermodel->setData($params);
			$customermodel->setWebsiteId(App::instance()->getWebsite()->getWebsiteId());
			if(isset($params['password'])){
				$password = $params['password'];
			} else {
				$password = Text::random($type = 'alnum', $length = 8);
			} 
			$customermodel->setPassword(md5($password));
			$customermodel->setCreatedDate(App::helper('date')->gmtDate()); 
			$customermodel->saveUser();
			$data['success'] = true;
		}
		catch(Validation_Exception $ve) {
				$session->setDatas('form_data',$request->post());
				Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true));
				$errors = $ve->array->errors('validation',true);
				$data['errors'] = $errors;
		} catch(Kohana_Exception $ke) {
				Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$e->getMessage())));
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
				Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$e->getMessage())));
				Log::Instance()->add(Log::ERROR, $e);
		}
		return $data;
	} 
	

	 
	public function updateProfile($params)
	{
		$data = array();
		$insurance = array();
		//return $params;
		if(isset($params['insurance'])){
			$insurance = explode(',',$params['insurance']);
			$params['insurance'] = $insurance;
		}
		
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
			$data['success'] = false;
		}
		$customermodel =  App::model('user',false)->loadByAllLanguages((int)$params['id']); 
		if(!$customermodel->getId()) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid User'),
				'field' => 'id',
			));
			$data['success'] = false;
		}
		$first_name = arr::get($params,'first_name');
		$params['first_name'] = $customermodel->getFirstName();
		$params['first_name'][$params['language_id']] = $first_name;
		
		$about =  array($params,'about');
		$params['about'] = $customermodel->getAbout();
		$params['about'][$params['language_id']] = $about;
		
		if(isset($params['venue'])){
			$venue = $params['venue'];
			$params['venue'] = $customermodel->getVenue();
			$params['venue'][$params['language_id']] = $venue;
		} 
		$dob=App::helper('date')->is_validdate(arr::get($params,'date_of_birth'));
		$params['date_of_birth'] = $dob;
		//print_r($params['date_of_birth']);exit;
		
		$customermodel->addData($params); 
		$customermodel->setPost(new Kohana_Core_Object($params));
		
		$customermodel->saveUser(); 
		$data['success'] = true;
		return $data;
	}
	
	public function updateAppUser($params) 
	{

		$data = array();
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
			$data['success'] = false;
		}
		$customermodel = clone $this->_model;		
		$user = App::model('user',false)->load($params['id']);
		if(isset($params['additional_mobile_number'])) {
			$mobiles = explode(',',$params['additional_mobile_number']);
			foreach($mobiles as $mobile) {
				$admobile = array('additional_mobile_number'=>trim($mobile),'additional_country_code'=>$params['additional_country_code']);
				try {
					$user = $user->addData($admobile);			
					$contacts = App::model('user/contacts')->validate($user)->saveNotPrimaryMobile($user);					
				} catch(Validation_Exception $ve) {
					$data['error'] = $ve->array->errors('validate/store',true);
				}
				catch(Exception $e) {
					$data['error'] = $e->getMessage();
					Log::Instance()->add(Log::ERROR, $e);
				}
			}	
		}
		if(isset($params['additional_email_address'])) {
			$emails = explode(',',$params['additional_email_address']);
			foreach($emails as $email) {
				$ademail = array('additional_email_address'=>$email);
				try {
					$user = $user->addData($ademail);			
					$contacts = App::model('user/email',false)->validateemail($user)->saveEmail($user);					
				} catch(Validation_Exception $ve) {
					$data['error'] = $ve->array->errors('validate/store',true);
				}
				catch(Exception $e) {
					$data['error'] = $e->getMessage();
					Log::Instance()->add(Log::ERROR, $e);
				}
			}	
		}
		if(isset($params['primary_email_address'])) {
			
			$primary = $customermodel->emailexists($params['primary_email_address'],$params['id']);
			if($primary){ 
				$data['error'] =  array('name'  =>  'primary_email_address',
											  'message' => __('This Email already exists')); 							
			} else {
				$customermodel->setPrimaryEmailAddress($params['primary_email_address']);
			}
		}
		if(isset($params['delete_mobile_number'])) {
			$mobiles = explode(',',$params['delete_mobile_number']);
			foreach($mobiles as $mobile) {
				try {		
					$contacts = App::model('user/contacts',false)->setUsers($user)->deleteMobile($mobile);					
				} catch(Validation_Exception $ve) {
					//print_r($ve); exit;
					$data['error'] = $ve->getMessage();
					Log::Instance()->add(Log::ERROR, $ve);
				}
				catch(Exception $e) {
					//print_r($e); exit;
					$data['error'] = $e->getMessage();
					Log::Instance()->add(Log::ERROR, $e);
				}
			}	
			
		}
		if(isset($params['delete_email_ids'])) {
			$emails = explode(',',$params['delete_email_ids']);
			foreach($emails as $email) {
				try {		
					$contacts = App::model('user/email',false)->setUsers($user)->deleteEmail($email);					
				} catch(Validation_Exception $ve) {
					$data['error'] = $ve->getMessage();
					Log::Instance()->add(Log::ERROR, $ve);
				}
				catch(Exception $e) {
					$data['error'] = $e->getMessage();
					Log::Instance()->add(Log::ERROR, $e);
				}
			}	
			
		}
		//$customermodel->save();
		if(!isset($data['error'])) {
			$data['success'] = true;	
		}
		return $data;
	}
	
	/** public function delete($params)
	{
		$data = array();
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
		}
		$customermodel = clone $this->_model; 
		$customermodel->setCustomerId((int) $params['id']);
		App::dispatchEvent('Customer_Delete_Before',array('post'=> $params,'customer' => $customermodel));
		//$customermodel->deleterow(); 
		App::dispatchEvent('Customer_Delete_After',array('post'=> $params,'customer' => $customermodel));
		$data['success'] = true;
		return $data;
	}
	**/
	
	public function password_update($params)
	{ 
		$data = array();
		if(!isset($params['id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing id'),
				'field' => 'id',
			));
			$data['success'] = false;
		}
		$customermodel = clone $this->_model;
		$user = $customermodel->check_password($params['id'],md5($params['old_password']));
		if($user){
			$customermodel->setUserId($params['id']);
			$customermodel->setPassword(md5($params['password']));
			$customermodel->saveUser();
			$data['success'] = true;
		}else{		
			throw HTTP_Exception::factory(400, array(
				'error' => __('Old password does not match'),
				'field' => 'id',
			));
		    $data['success'] = false;
		}
		return $data;
	}
	
	
	public function forgot_password($params)
	{ 
		$data = array();
		if(!isset($params['email'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing Email'),
				'field' => 'email',
			));
			$data['success'] = false;
		}
		$customermodel = clone $this->_model;
		$user = $customermodel->_validateEmail($params['email']);
		if($user){
			$customer=$customermodel->load($params['email'],'primary_email_address');
			//$role=$customer->getAssociatedStores()->getAssociatedRoles(1);
			//$owner=$customermodel->checkOwnerapi($customer->getUserId(),App::ADMIN,1);
			$template = App::model('core/email_template')->load(self::EMAIL_TEMPLATE_FORGET_PASSWORD);
			$from = $template->getFromEmail();
			$from_name=$template->getFrom();
			$subject = $template->getSubject();
			if(!$template->getTemplateId()) {
				$template = 'mail_template';
				$from=App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN);
				$subject = __("Forgot Password");
				$from_name="";
			}
			$website = App::model('core/website',false)->load(App::FRONTEND);
			$siteUrl = $website->getWebUrl();
			$secure_key = Encrypt::instance()->encode(Text::random('alnum',15));
			$verification_code=Text::random('nozero',6);
			$customermodel->setUserId($customer->getUserId());
			$customermodel->setPasswordVerificationKey($secure_key);
			$customermodel->setPasswordVerificationCode($verification_code);
			$customermodel->setVerificationLinkExpiryStatus(1);
			$customermodel->save();
			$template = App::model('core/email_template')->load(self::USERS_RESET_PASSWORD_EMAIL_TEMPLATE);
			$url1 ='<a href="'.$siteUrl.'account/resetpassword?key='.urlencode($secure_key).'"> Click here </a>';
			$from = $template->getFromEmail();
			$from_name=$template->getFrom();
			$subject = $template->getSubject();
			$content = array("customer" => $customer,"reset_passoword_link" => $url1,'code'=>$verification_code);
			$email=App::model('core/email')->smtp($from,$from_name,$customer->getPrimaryEmailAddress(),$subject,$content,$template);
			$data['success'] = true;
			
		}else{		
		
			throw HTTP_Exception::factory(400, array(
				'error' => 'email does not exist',
				'field' => 'id',
			));
		    $data['success'] = false;
		}
		return $data;
	}
	
	
	
	public function getprofilecompletion($params)
	{ 
		$id=(int)Request::current()->param('param');
		$this->_params = $params; 
		$user=$this->_model->load($id);	
		if($user->getUserId()){
			$settings = App::getConfig('PROFILE_SETTINGS',Model_Core_Place::ADMIN);
			$total=0;
			foreach($user->getData() as $key => $val){
				if(isset($settings[$key])== $key){
					if($val!=''){
						$total +=$settings[$key];
					}
				}
			}
			$resultant = $total; 
			if(isset($params['single'])) {
				return $resultant;
			}
			$this->_totalItems = 1;
		}else{ 	
			$this->_prepareList(); 
			$resultant = $this->as_array();
		}
		return array('details' => $resultant,'total_rows' => $this->_totalItems);
	}
	
	public function profile_picture_update($params,$files)
	{ 
		$responce =$this->_model->profile_update($params,$files);
        return $responce;
	}
	
	
	public function addActivity($params)
	{ 
		$data = array();
		if(!isset($params['user_id'])) {
			throw HTTP_Exception::factory(400, array(
				'error' => __('Missing Id'),
				'field' => 'user_id',
			));
			$data['success'] = false;
		}
		$customermodel = clone $this->_model;
		$customer=$customermodel->load($params['user_id']);
		if($customer->getId()){
			$user=$customer->addUseractivity($params);
			if($user){
				$data['success'] = true;
			}
		}else{		
			throw HTTP_Exception::factory(400, array(
				'error' => __('Invalid User'),
				'field' => 'user_id',
			));
		    $data['success'] = false;
		}
		return $data;
	}
	
	public function selectlog($params)
	{
		$result = array('kill_access' => 'false');
		if(Arr::get($params,'device_token')) {
			 
			$devicelog = App::model('user/devicelog',false)->load($params['device_token'],'device_token');
		 
			$result['kill_access'] = $devicelog->getKillAccess() == 't' ? 'true' : 'false';
		}
		
		$result['subscription_days'] = 0;
		$result['subscription_date'] = false;
		$result['place_deleted'] = false;
		if(isset($params['place_id'])) {
			$currentplace = App::model('core/place',false)->load($params['place_id']); 
			if($currentplace->getId()) {
				$placeid = $currentplace->getId(); 
				if(!$currentplace->isCompany()) {
					if($currentplace->getParent()) {
						$placeid = $currentplace->getParent()->getId();
					}
				} 
				$subscription = App::model('subscriptionplace',false)->load($placeid,'place_id');
				$result['subscription_days'] = $subscription->getNoDays();
				$result['subscription_date'] = $subscription->getToDate();
			} else {
				$result['place_deleted'] = true;
			}
			$roleupdated='';
			if(isset($params['role_id']) && $params['role_id']!='') { 
				$roleupdated = App::model('core/api',false)->getApiaccountupdated($params['role_id'],$params['place_id']);
			}
			$result['role_updated_date'] = $roleupdated;
			
		}
		return $result;
	}
	
	public function delete($params)
	{
		if(!Arr::get($params,'device_token')) {
			throw new Kohana_Exception(__('Need device token'));
		}
		if(!Arr::get($params,'user_id')) {
			throw new Kohana_Exception(__('Invalid user'),NULL,ERROR_INVALID_USER);
		}
		$result = array();
		$result['success'] = false;
		$user = App::model('user',false)->load(Arr::get($params,'user_id'));
		if($user->getId()) {
			$deviceid = DB::select("device_id")->from(App::model('core/mobile_device')->getTableName())
										->where('device_token','=',Arr::get($params,'device_token'))
										->where('user_id','=',$user->getId())
										->execute()->get('device_id'); 
			if($deviceid) {
				$delete = App::model('core/mobile_device',false)->load($deviceid);		 
				$delete->deleterow();    
				$result['success'] = true;
			}
		} 
		return $result;
 	}
	
	public $params = array();
	
	public function _initUser()
	{
		parent::_construct();
		if(Arr::get($this->params,'_usr')) {
			$userid = Arr::get($this->params,'_usr',false); 
			$user = App::model('user',false);
			if($userid) {			
				$user->load($userid,'user_token');
			}
		} else if(Arr::get($this->params,'user_token')) {
			$userid = Arr::get($this->params,'user_token',false); 
			$user = App::model('user',false);
			if($userid) {			
				$user->load($userid,'user_token');
			}
		}
		
		$this->setCurrentUser($user);
	}
	
	public function addSettings()
	{
		$json = array();
		$this->_initUser(); 
		$user = $this->getCurrentUser();
		if(!$user->getId()) {
			throw new Kohana_Exception(__('Invalid User'),NULL, ERROR_INVALID_USER);
		}
		if(Arr::get($this->params,'key') =="" || Arr::get($this->params,'value') == "") {
			throw new Kohana_Exception(__('Missing params values'),NULL, ERROR_MISSING_PARAMETER_VALUE);
		}
		$user->addSettings(Arr::get($this->params,'key'),Arr::get($this->params,'value'));
		$json['success'] = true;
		return $json;
	}
	
	public function getSettings()
	{ 
		$this->_initUser();
		$user = $this->getCurrentUser();
		if(!$user->getId()) {
			throw new Kohana_Exception(__('Invalid User'),NULL, ERROR_INVALID_USER);
		}
		$set = array();
		$select = DB::select('config_id','user_id','name','value')->from(App::model('user/settings')->getTableName())
						->where('user_id','=',$user->getId())
						->execute()->as_array(); 
		foreach($select as $s) {
			$set[$s['name']] = $s['value'];
		} 
		return array('settings' => $set);
	}
	
	public function contactus($params)
	{ 
		$this->auto_render = false;
		$data = $params;
		$json = array();
		$json = false;
		$customermodel = App::model('user');
		try {
			$validate = $customermodel->validatecontactus($data);			
			$template = App::model('core/email_template',false)->load(self::CONTACTUS_EMAIL_TEMPLATE);
			$admintemplate = App::model('core/email_template',false)->load(self::CONTACTUS_ADMIN_EMAIL_TEMPLATE);
			$customer = App::model('login')->load($data['email'],'primary_email_address');
			$from = $template->getFromEmail();
			$from_name=$admintemplate->getFrom();
			$subject = $template->getSubject();
			$adminfrom = $admintemplate->getFromEmail();
			$adminfrom_name=$admintemplate->getFrom();
			$adminsubject = $admintemplate->getSubject();
			if(!$template->getTemplateId()) {
				$template = 'mail_template';
				$from=App::getConfig('CONTACT_EMAIL');
				$subject = __("Thank you for contact us.").App::getConfig('SITE_NAME');
				$from_name="";
			}
			if(!$admintemplate->getTemplateId()) {
				$admintemplate = 'mail_template';
				$adminfrom=App::getConfig('CONTACT_EMAIL');
				$adminsubject = __("Reg - User contact").App::getConfig('SITE_NAME');
				$adminfrom_name="";
			}
			$content = array("customer" => $customer,'name'=>$data['name']);
			$ContentForAdmin = array("customer" => $customer,'name'=>$data['name'],'email'=>$data['email'],'mobile'=>$data['mobile'],'message'=>$data['message']);
			$email=App::model('core/email')->smtp($from,$from_name,$customer->getPrimaryEmailAddress(),$subject,$content,$template);
			$email=App::model('core/email')->smtp($adminfrom,$adminfrom_name,$adminfrom,$adminsubject,$ContentForAdmin,$admintemplate);
			$json = true;												
		} catch(Validation_Exception $ve) { 
			$errors = $ve->array->errors('validation',true); 
			$json['errors'] = $errors; 
		} catch(Exception $e) {
			$json['error'] = $e->getMessage();
		} 
		return array('result' => $json);	
	}
	
}
