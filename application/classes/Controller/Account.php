<?php defined('SYSPATH') or die('No direct script access.'); 

class Controller_Account extends Controller_Core_Front {
	
	protected $_user;
	protected function _initUsers()
    {
		 
		$id = $this->getRequest()->query('id');
		if(!$id)
		{
		   $session = App::model('user/session');
		   $id = $session->getId();
		}		
        $this->_user = App::model('user',false)->load($id); 
		App::register('users',$this->_user);
        return $this->_user;
    }
	
	protected function _onlyForDoctor()
	{
		if(!$this->_user->isDoctor()) {
			$this->page404();
		} 
	}
	
	protected function _getUser()
	{
		return $this->_user; 
	}
	
	protected function _checkLogin()
	{
		$session = App::model('user/session');
		if($session->isLoggedIn()) { 
			return true;
		}
		$this->_redirectUrl('signin');
		return false;
	}
	
	public function action_resetpassword() 
	{
		$query = $this->getRequest()->query();
		if(!isset($query['key'])){
			$this->_redirect('/');
		}
		$customer=App::model('user')->load($query['key'],'password_verification_key');
		if(!$customer->getId()){
			$this->page404();die();
		}
		if(!$customer->getVerificationLinkExpiryStatus()){
			$this->page404();die();
		}
		$this->loadBlocks('login');		
		$this->renderBlocks();
	}
	
	public function action_changepassword() 
	{
		$this->_noCacheHeaders();
		$this->_initUsers();
		$this->_checkLogin();
		$this->loadBlocks('account');
		$breadcrumb = $this->getBlock('breadcrumbs');
		$breadcrumb->addCrumb('myprofile',array('label' => __('Edit profile'),'title' => __('Edit profile'),'link' => 'account/edit','account' => true));
		$breadcrumb->addCrumb('changepassword',array('label' => __('Change password'),'title' => __('Change password')));
		$session = App::model('user/session');		
		if($session->getValidationErrors()){
			$this->getBlock('changepassword')->setValidationErrors($session->getValidationErrors());
			$session->unsetData('validation_errors');
		}	
		$this->renderBlocks();
	}
	
	public function action_changepasswordupdate() 
	{
		$session = App::model('user/session');
		$this->auto_render = false;
		$request = $this->getRequest();
		$data = $request->post();
		$success = false;
		$id = $data['user_id'];
		$errors = array();
		$query = $this->getRequest()->query();
		if($this->getRequest()->query('return_url')) {
			$query['return_url'] = urldecode($this->getRequest()->query('return_url'));
		}
		try {
			if($id){
				$user = App::model('user',false)->load($id);
			}else{
				throw new Exception('Invalid User');
			}
			$user->setUserId($data['user_id']);
			$validate = $user->validatepassword($data);
			if($validate){
				if($data['password'] == $data['retype_pass']){
					$user->addData($data);
					$user->setPassword(md5($data['password']));	
					$user->save($data);
					$success = true;
				}
			}
			$session->unsetData('form_data');
			
		}
		catch(Validation_Exception $ve) {
			//print_r($ve);exit;
				$session->setDatas('form_data',$request->post());
				//Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true));
				$errors = $ve->array->errors('validation',true);
				$session->setDatas('validation_errors',$errors);
		} catch(Kohana_Exception $ke) {
			//print_r($ke);exit;
				Notice::add(Notice::ERROR, __('Problem in server'));
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			//print_r($e);exit;
				Notice::add(Notice::ERROR, __('Problem in server'));
				Log::Instance()->add(Log::ERROR, $e);
		}
		
		if($success){
			Notice::add(Notice::SUCCESS, __('Password changed successfully'));
			$this->_redirectUrl(App::helper('url')->getAccountUrl('account/changepassword',$query));
		}
		$this->_redirectUrl(App::helper('url')->getAccountUrl('account/changepassword',$query));
		return $this;
	}
	
	public function action_savepassword() 
	{ 
		$user = App::model('login');	
		$this->auto_render = false;
		$request = $this->getRequest();
		$data = $request->post();
		$json = array();
		$status="";
		$success=false;
		if(!empty($data)) {
			try {
				$user=App::model('user')->passwordValidate($data);
				if(!empty($data['verification_code']) && !empty($data['key'])) {
					$customer=App::model('user')->selectAttributes('*')->filter('password_verification_key',array('=',$data['key']))->filter('password_verification_code',array('=',$data['verification_code']))->loadCollection();
						if(count($customer) ) {
							$customermodel = $customer[0];
							$customermodel->setPassword(md5($data['password']));
							$customermodel->setVerificationLinkExpiryStatus('0');
							$customermodel->save();
							$success=true;
							Notice::add(Notice::SUCCESS,__('Your password has been changed successfully.'));
							$json['success'] = __('Your password has been changed successfully.');
						}else {
							$json['error'] = array('code'=>__('This Code does not exists '));
						}	
				}else{
					$json['error'] = $e->getMessage(); 
				}
			}  
			catch(Validation_Exception $ve) {
				$json['error'] = $ve->array->errors('user',true);
			}
			catch(Exception $e) {
				$json['error'] = $e->getMessage();
				Log::Instance()->add(Log::ERROR, $e);
			}
		}else {
			$json['error'] = array('code'=>__('Invalid Reqest'));
		}
		$this->getResponse()->body(json_encode($json));
	}
	
	public function action_uploadgallery()
	{
		$json = array();
		$filename = NULL; 
        if ($this->request->method() == Request::POST)
        {
            if (isset($_FILES['gallery_image']))
            {
				$uploaddir = 'uploads/user'.DIRECTORY_SEPARATOR.$this->getRequest()->query('report_id');
				if(!file_exists(DOCROOT.$uploaddir)) {
					mkdir(DOCROOT.$uploaddir,0777,true);
				}
                $filename = $this->_save_image($_FILES['gallery_image'],DOCROOT.$uploaddir);
				$json['file'] = basename($filename);
				$model = App::model('core/report/gallery')->setReportId($this->getRequest()->query('report_id'))
						->setFile($uploaddir.DIRECTORY_SEPARATOR.basename($filename))
						->setFileType($_FILES['gallery_image']['type'])
						->setAddedOn(date("Y-m-d H:i:s"))
						->save();
            }
        }

        if (!$filename) {
            $json['error'] = 'There was a problem while uploading the image.
                Make sure it is uploaded and must be JPG/PNG/GIF file.';
        }
		$this->getResponse()->body(json_encode($json));
	}

	protected function _save_image($image, $dir)
    {
        if (! Upload::valid($image) OR
            ! Upload::not_empty($image) OR
            ! Upload::type($image, array('jpg', 'jpeg', 'png', 'gif','pdf','csv','xls')))
        {
            return FALSE;
        }
        $directory = $dir;
        if ($file = Upload::save($image, $image['name'], $directory)) {
            return $file;
        }
        return FALSE;
    }

	public function action_deletegallery()
	{
		$json = array();
		$request = $this->getRequest();
		
		$json['success'] = false;
		if($request->query('image')) {
			$image = base64_decode($request->query('image'));
			$report_id = $request->query('report_id');
			$delete = DB::delete(App::model('core/report/gallery')->getTableName())->where('file','=',$image)->where('report_id','=',$report_id)
						->execute(App::model('core/report/gallery')->getDbConfig());
			if(file_exists(DOCROOT.$image)) {
				unlink(DOCROOT.$image);
			}
			$json['success'] = true;
		}
		$this->getResponse()->body(json_encode($json));
	}
	
	public function action_edit() 
	{
		$this->_noCacheHeaders();
		$this->_initUsers();
		$this->_checkLogin();
		$session = App::model('user/session');
		$this->loadBlocks('account');
		$user = App::model('user',false)->setData($session->getFormData());
		$id = $session->getId();
		
		if(!$id) {
			Notice::add(Notice::ERROR, __('Invalid User'));
			$this->_redirect('/');
		}
		if($id){
			$user->loadByAllLanguages($id);
			if(!$user->getUserId()) {
			Notice::add(Notice::ERROR, __('Invalid User'));
			$this->_redirect('/');
			}
		}
		App::register('users',$user);
		if($session->getValidationErrors()){
			$this->getBlock('doctorprofilepage')->setValidationErrors($session->getValidationErrors());
			$this->getBlock('patientprofilepage')->setValidationErrors($session->getValidationErrors());
			$session->unsetData('validation_errors');
		}
		$this->renderBlocks();
	}
	
	public function action_settings() 
	{
		$this->_noCacheHeaders();
		$this->_initUsers();
		$this->_checkLogin();
		$this->loadBlocks('settings');
		$this->renderBlocks();
	}
	
	public function action_appointments() 
	{
		$this->_noCacheHeaders();
		$this->_initUsers();
		$this->_checkLogin();
		$this->loadBlocks('settings');
		$this->renderBlocks();
	}
	
	public function action_reports() 
	{
		$this->_noCacheHeaders();
		$this->_initUsers();
		//$this->_onlyForDoctor();
		$this->_checkLogin();
		$this->loadBlocks('settings');
		$this->renderBlocks();
	}
	
	public function action_reportajax() 
	{
		$this->_noCacheHeaders();
		$this->_initUsers();
		//$this->_onlyForDoctor();
		$this->_checkLogin();
		$this->loadBlocks('settings');
		$output = $this->getBlock('reports')->toHtml();
		$this->getResponse()->body($output);
	}
	
	public function action_getdoctors()
	{
		$request = $this->getRequest();
		$q = $request->query('q');
		$excludeid = $request->query('d');
		$json = array();
		if(!$q) {
			
		}
		$doctors = $this->_getRotateDoctors($q,array($excludeid));
		$this->getResponse()->body(json_encode($doctors)); 
	}
	
	private function _getRotateDoctors($q, $excludeid = array()) {
		$select = App::model('user',false)->selectAttributes(array('first_name','social_title'))
					->filter('user_id',array('not in', (array) $excludeid))
					->filter('first_name',array('like','%'.$q.'%'))
					->filter('user_type',array('=', Model_User::DOCTOR))
					->limit(10);
		$select->getSelect()->join(array(App::model('subscription')->getTableName(),'s'),'inner')
                        ->on('s.entity_type','=',DB::expr(Model_User::ANGES_SAM))
                        ->on('s.entity_id','=','main_table.user_id')
                        ->where('s.subscription_date','>',Date::formatted_time());
		
		$doctors = array();
		foreach($select->loadCollection() as $s) {
			$doctors[] =array('id' => $s->getId(), 'name' => $s->getFullName());
		}
		return $doctors;
	}
	
	public function action_appreportajax() 
	{
		$this->_noCacheHeaders();
		$this->_initUsers();
		//$this->_onlyForDoctor(); 
		$this->loadBlocks('settings');
		$output = $this->getBlock('reports')->toHtml();
		$this->getResponse()->body($output);
	}
	
	public function action_timings() 
	{
		$this->_noCacheHeaders();
		$this->_initUsers();
		$this->_onlyForDoctor();
		$this->_checkLogin();
		$user = $this->_getUser();
		$user->unsetData('timeerror');
		$session = App::model('core/session');
		$user->setVideo(array());
		if($session->getFormData()) { 
			$this->_localSessionData(); 
			$user->addData($session->getFormData()); 
			$session->unsetData('form_data');
		}
		if($session->getTimeerror()) {
			$user->setTimeError($session->getTimeerror());
			$session->unsetData('timeerror');
		}
		$this->loadBlocks('settings');
		$this->renderBlocks();
	}
	
	public function action_media() 
	{ 
		$this->_initUsers();
		$this->_onlyForDoctor();
		$this->_checkLogin();
		$session = App::model('core/session'); 
		$user = $this->_getUser();
		$user->setVideo(array());
		if($session->getFormData()) { 
			$this->_localSessionData(); 
			$user->addData($session->getFormData()); 
			$session->unsetData('form_data');
		}
		$this->loadBlocks('settings');
		$this->renderBlocks();
	}
	
	public function action_generatereport() 
	{
		$this->_noCacheHeaders();
		$this->_initUsers();
		//$this->_onlyForDoctor();
		$this->_checkLogin();
		$this->loadBlocks('account');
		$this->renderBlocks();
	}
	
	public function _localSessionData()
	{
		$session = App::model('core/session');
		$data = $session->getFormData(); 
		 
		if(isset($data['timing'])) { 
			$dayarray = App::model('core/timings')->getDaysWeekArray(); 
			$timeset = array();
			$secondshift = Arr::get($data,'second_shift',array());
			foreach($data['timing'] as $key => $values) {
				$shift2 = Arr::get($secondshift,$key); 
				if(Arr::get($values,'istrue')) {
					$timeset[$key]['day_week'] = Arr::get($dayarray,$key);
					$timeset[$key]['start_time'] = App::helper('time')->convertTime(Arr::get($values,'from'));
					$timeset[$key]['end_time'] = App::helper('time')->convertTime(Arr::get($values,'to')); 
					$timeset[$key]['second_shift_status'] = 0;
				}
				if(Arr::get($shift2,'istrue')) {
					$timeset[$key]['second_shift_status'] = 1;
					$timeset[$key]['shift_start_time'] = App::helper('time')->convertTime(Arr::get($shift2,'from'));
					$timeset[$key]['shift_end_time'] = App::helper('time')->convertTime(Arr::get($shift2,'to')); 
				} 
			} 
			$data['timings'] = App::model('core/timings')->parseTimings($timeset);
		}
		$session->setDatas('form_data',$data);
	}
	
	public function action_viewappointments() 
	{
		$this->_noCacheHeaders();
		$this->_initUsers();
		$this->_checkLogin();
		$this->loadBlocks('settings');
		$app_ref_id = $this->getRequest()->query('apptid');
		$breadcrumb = $this->getBlock('breadcrumbs');
		$breadcrumb->addCrumb('appointment',array('label' => __('My appointment'),'title' => __('My appointment'),'link' => 'account/appointments','account' => true));
		//$breadcrumb->addCrumb('viewappointment',array('label' => __('View appointment'),'title' => __('View appointment'),'link' => ''));
		$breadcrumb->addCrumb('viewappointmentnew',array('label' => $app_ref_id,'title' => $app_ref_id));
		$appointment_model = App::model('core/appointments',false)->load($app_ref_id,'reference_id');
		if(!$appointment_model->getId()){
			Notice::add(Notice::ERROR, __('Invalid Appointment'));
			$this->_redirectUrl(App::helper('url')->getAccountUrl('account/appointments'));
		}
		if(!$this->_getUser()->isDoctor()){
			if($appointment_model->getUserId() != $this->_getUser()->getId()){
				Notice::add(Notice::ERROR, __('Invalid Appointment'));
				$this->_redirectUrl(App::helper('url')->getAccountUrl('account/appointments'));
			}
		}
		App::register('appointments',$appointment_model);
		$this->renderBlocks();
	}
	 
	
	public function action_viewprofile() 
	{
		$this->_noCacheHeaders();
		$this->_noCacheHeaders();
		$this->_initUsers();
		$session = App::model('user/session');
		$this->loadBlocks('account');
		$user = App::model('user',false)->setData($session->getFormData());
		$id = $session->getId();
		if(!$id) {
			Notice::add(Notice::ERROR, __('Invalid User'));
			$this->_redirect('/');
		}
		if($id){
			$user->loadByAllLanguages($id);
			if(!$user->getUserId()) {
			Notice::add(Notice::ERROR, __('Invalid User'));
			$this->_redirect('/');
			}
		}
		$this->getBlock('profilepage')->setUsers($user);		
		$this->renderBlocks();
	}
	
	public function action_mysearches() 
	{
		$this->_noCacheHeaders();
		$this->_noCacheHeaders();
		$this->_initUsers();
		$session = App::model('user/session');
		$this->loadBlocks('account');
		$this->getBlock('head')->setTitle(__('My Searches and Views'));
		$user = App::model('user',false)->setData($session->getFormData());
		$id = $session->getId();
		if(!$id) {
			Notice::add(Notice::ERROR, __('Invalid User'));
			$this->_redirect('/');
		}
		if($id){
			$user->loadByAllLanguages($id);
			if(!$user->getUserId()) {
			Notice::add(Notice::ERROR, __('Invalid User'));
			$this->_redirect('/');
			}
		}
		$this->getBlock('profilepage')->setUsers($user);		
		$this->renderBlocks();
	}
	
	public function action_blocksearch() 
	{  
		$request = $this->getRequest();
		$search_id=$this->getRequest()->query('id');		
		$searchmodel = App::model('core/usersearches')->deleteRow($search_id,"id");		
		$this->_redirect('account/mysearches');
	}
	
	
	
	public function action_profile_picture() 
	{
		$this->auto_render = false;
		$data = $this->getRequest()->query();
		$user = App::model('user',false)->profile_update($data,$_FILES);
		$this->getResponse()->body(json_encode($user));
	}
	
    
    public function action_myappointments() 
	{
		
		$this->_noCacheHeaders();
		$this->_initUsers();  
		$session = App::model('user/session');
		$this->loadBlocks('account');
		$this->getBlock('head')->setTitle(__('My Appointments'));
		$user = App::model('user',false)->setData($session->getFormData());
		$id = $session->getId();
		if(!$id) {
			Notice::add(Notice::ERROR, __('Invalid User'));
			$this->_redirect('/');
		}
		if($id){
			$user->load($id);
			if(!$user->getUserId()) {
				Notice::add(Notice::ERROR, __('Invalid User'));
				$this->_redirect('/');
			}
		}
		$this->getBlock('profilepage')->setUsers($user);		
		$this->renderBlocks();
	}
	
	public function action_deleteappointment()
    {
		$session = App::model('user/session');
		$id = $session->getId();
		$user = App::model('user',false)->load($id);
		$json = array();
		$request = $this->getRequest();
		try {
			$appointmentmodel = App::model('core/appointment/booking',false)->load($this->getRequest()->query('id'));
			if($user->getId() != $appointmentmodel->getUserId()) {
				Notice::add(Notice::ERROR, __('Invalid Appointment'));
				$this->_redirect('account/myappointments');
			}
				
			$appointmentmodel->deleteRow();
			if($appointmentmodel) {
				Notice::add(Notice::SUCCESS, __('Appointment entry was removed'));
			} else {
				Notice::add(Notice::ERROR, __('Error while removing.'));
			}
		} catch(Exception $e) {
			Notice::add(Notice::ERROR,$e->getMessage());
			Log::Instance()->add(Log::ERROR, $e);
		}
		$this->_redirect('account/myappointments');
    }
	
	public function action_acceptappointment()
	{
		$session = App::model('user/session');
		$user = $session->getCustomer();
		$request = $this->getRequest();
		try { 
			$appointmentmodel = App::model('core/appointment/booking',false)->load($request->query('book_id'));
			if($user->getId() != $appointmentmodel->getUserId()) {
				Notice::add(Notice::ERROR, __('Invalid Appointment'));
				$this->_redirect('account/myappointments');
			}
			$appointmentmodel->setUserAccept(true)
							->save(); 
			Notice::add(Notice::SUCCESS,__('Data Updated successfully'));
		} catch(Kohana_Exception $e) {
			Notice::add(Notice::ERROR,$e->getMessage());
		} catch(Exception $e) {
			Notice::add(Notice::ERROR,__('Problem in the server. try again later'));
			Log::Instance()->add(Log::ERROR, $e);
		}
		$this->_redirect('account/myappointments');
	}
	
	
	
	public function action_getAdBanner() 
	{
		$post = $this->getRequest()->post();	
		if(isset($post['latitude']) && isset($post['longitude']) && isset($post['bannertype']) && isset($post['position']) && isset($post['city']))	 {
			if(!empty($post['latitude']) && !empty($post['longitude']) && !empty($post['bannertype']) && !empty($post['position']) && !empty($post['city'])) {
				$latitude = $post['latitude'];
				$longitude = $post['longitude'];
				$bannertype = $post['bannertype'];
				$position = $post['position'];
				$city = $post['city'];
				$block = Block::factory('account');
				
				$bannerview = $block->createBlock('Front/Account/Advertisement')
					->setTemplate('ads/ads')
					->setBannerType($bannertype)
					->setPosition($position)
					->setLat($latitude)
					->setLon($longitude)
					->setCity($city)
					->toHtml();
				$this->getResponse()->body($bannerview);	
			}
		}
	}
	
	public function action_creditpdf()
	{
		$credit = App::model('credit',false)->load($this->getRequest()->query('slip_id'));
		if(!$credit->getId()) {			
			$this->_redirect('account/myorders');
		}
		$order = App::model('sales',false)->load($credit->getOrderId());
		if($order->getUserId() != App::model('user/session')->getId()) {
			$this->_redirect('account/myorders/id/'.$order->getOrderReference());
		}
		$date = str_replace(" ","_",Date::formatted_time());
		$fileName   = $credit->getMemoReference().'_'.$date.'.pdf';
		$this->loadBlocks('account');
		App::register('credit',$credit);
		$output = $this->getBlock('listing')->setOrder($order)->getPdfFile(); 
		$this->_prepareDownloadResponse($fileName, $output);
	}
	
	public function action_return()
	{
		$itemid = $this->getRequest()->query('item_id');
		if(!$itemid) {
			return '';
		}
		$item = App::model('sales/place_items')->load($itemid);
		$this->loadBlocks('account'); 
		$output = $this->getBlock('listing')->setItem($item);
		$this->getResponse()->body($output->toHtml());
	}
	
	public function action_returnsubmit()
	{
		$this->auto_render = false;
		$json = array();
		$request = $this->getRequest();
		$model = App::model('sales/return',false);
		try {
			$item = App::model('sales/place_items',false)->load($request->query('itemid'));
			$returnreason = $item->getReturnReasons();
			if(!$item->getId()) {
				throw new Kohana_Exception(__('Invalid Item'));
			}
			$placeorder = $item->getPlaceOrder();
			$order = $placeorder->getOrder();
			$item->setPlaceName($placeorder->getPlace()->getPlaceName());
			$model->setRequestReason($request->post('return_reason'))
					->setComment($request->post('comments'))
					->setDateAdded(Date::formatted_time())
					->setOrderId($order->getId())
					->setItemId($item->getId());
			$model->save(); 
			/*
			$notification = App::helper('notification')->setUseTemplateData(true)->ForceStopEmailNotification()
					->setCustomTemplateId(44);
			$notification->setPlace(array($item->getPlaceOrder()->getPlaceId())); 			
			$notification->setSenders(array(null,App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN)));		 
			$notification->setVariables(array('item' => $item, 'user' => $order->getCustomer(), 'order' => $order, 'custom' => new Kohana_Core_Object(array('message' => $request->post('comments'),
																									   'reason' => Arr::get($returnreason,$request->post('return_reason')),
																									   'date' => Date::formatted_time('now','d M Y h:i A')
																												))));
																												
		 
			$notification->sendNotification(); 
			* */
			
			$subtype = 'return_request';
			
			$notification=App::helper('notification');			
			$notification->setSenders(array(null,App::getConfig('CONTACT_EMAIL',Model_Core_Place::ADMIN)));
			$notification->setSubjectType($subtype);
			$notification->setSubject('You have received a return request from the user');
			$notification->setVariables(array('item' => $item, 'user' => $order->getCustomer(), 'order' => $order, 'custom' => new Kohana_Core_Object(array('message' => $request->post('comments'),
																									   'reason' => Arr::get($returnreason,$request->post('return_reason')),
																									   'date' => Date::formatted_time('now','d M Y h:i A')
																												))));
			$notification->setPlace(array($item->getPlaceOrder()->getPlaceId()));
			$notification->ForceStopEmailNotification();			
			$notification->sendNotification();
							
			$json['success'] = true;
		}catch(Kohana_Exception $e) {
			$json['success'] = false;
			$json['error'] = $e->getMessage();
			
		} catch(Exception $e) {
			
			$json['error'] = __('Error in server. Please try again');
			$json['error'] = $e->getMessage();
			$json['success'] = false;
		}
		$this->getResponse()->body(json_encode($json)); 
	}
	
	public function action_signin()
	{
		$session = App::model('user/session');
		$formdata = $session->getData('form_data');
		$session->unsetData('form_data');
		$this->loadBlocks('account');
		$query = $this->getRequest()->query();
		
		if($session->isLoggedin()){
			$this->_redirect('',$query);
		}	
		if($session->getValidationErrors()){
			$this->getBlock('signin')->setValidationErrors($session->getValidationErrors())->setFormData($formdata);
			$session->unsetData('validation_errors');
		}
		$this->renderBlocks();
	}
	
	public function action_signup()
	{ 
		$session = App::model('user/session');
		$formdata = $session->getData('form_data');
		$session->unsetData('form_data');
		$query = $this->getRequest()->query();
		$this->loadBlocks('account');
		$session = App::model('user/session');	
		if($session->isLoggedin()){
			$this->_redirect('',$query);
		}	
		if($session->getValidationErrors()){
			$this->getBlock('signuppage')->setValidationErrors($session->getValidationErrors())
						->setFormData($formdata);
			$session->unsetData('validation_errors');
		}
		$this->renderBlocks();
	}
	
	/*public function action_doctorsignup()
	{
		$this->loadBlocks('account');
		$session = App::model('user/session');		
		if($session->getValidationErrors()){
			$this->getBlock('doctorsignup')->setValidationErrors($session->getValidationErrors());
			$session->unsetData('validation_errors');
		}
		$this->renderBlocks();
	} */
	
	public function action_updatePatient()
    {
		$this->_noCacheHeaders();
		$this->_initUsers();
		$request = $this->getRequest();		
		$success = false;
		$errors = array();
		$id = $request->post('user_id');
		$query = $this->getRequest()->query();
		$session = App::model('user/session');
		try {
			if($id){
				$user = App::model('user',false)->load($id);
			}else{
				throw new Exception('Invalid User');
			}
			$dob=App::helper('date')->is_validdate($request->post('date_of_birth'));
			$request->post('date_of_birth',$dob);
			$user->validatefrontpatient($request->post());
			$user->addData($request->post());
			$user->setUpdatedDate(date("Y-m-d H:i:s"));
			$user->setMobile($request->post('mobile'));
			$user->setCountry($request->post('country_id'));
			$user->setCity($request->post('city_id'));
			$user->setArea($request->post('area_id'));
			$user->saveUser(); 
			$success = true;
			$session->unsetData('form_data');
		} catch(Validation_Exception $ve) {
				$session->setDatas('form_data',$request->post());
				//Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true));
				$errors = $ve->array->errors('validation',true);
				$session->setDatas('validation_errors',$errors);
		} catch(Kohana_Exception $ke) {
				Notice::add(Notice::ERROR, __('Problem in server'));
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
				Notice::add(Notice::ERROR, __('Problem in server'));
				Log::Instance()->add(Log::ERROR, $e);
		}
		if($success) {
			Notice::add(Notice::SUCCESS, __('Profile updated successfully'));
			$this->_redirectUrl(App::helper('url')->getAccountUrl('account/edit',$query));
		}
		$this->_redirectUrl(App::helper('url')->getAccountUrl('account/edit',$query));
		return $this;
    }
    
	public function action_updateDoctor()
    {
		$this->_noCacheHeaders();
		$this->_initUsers();
		$request = $this->getRequest();		
		$success = false;
		$errors = array();
		$id = $request->post('user_id');
		$query = $this->getRequest()->query();
		$session = App::model('user/session');
		try {
			if($id){
				$user = App::model('user',false)->load($id);
			}else{
				throw new Exception('Invalid User');
			}
			$dob=App::helper('date')->is_validdate($request->post('date_of_birth'));
			$request->post('date_of_birth',$dob);
			$user->validatefrontDoctor($request->post());
			$user->addData($request->post());
			$user->setUpdatedDate(date("Y-m-d H:i:s"));
			$user->setMobile($request->post('mobile'));
			$user->setVenue($request->post('venue'));
			$user->setAbout($request->post('about'));
			$user->setCountry($request->post('country_id'));
			$user->setCity($request->post('city_id'));
			$user->setArea($request->post('area_id'));
			$user->saveUser(); 
			$success = true;
			
			$session->unsetData('form_data');
		} catch(Validation_Exception $ve) {
			//print_r($ve);exit;
				$session->setDatas('form_data',$request->post());
				//Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true));
				$errors = $ve->array->errors('validation',true);
				$session->setDatas('validation_errors',$errors);
		} catch(Kohana_Exception $ke) {
			//print_r($ke);exit;
				Notice::add(Notice::ERROR, __('Problem in server'));
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
			//print_r($e);exit;
				Notice::add(Notice::ERROR, __('Problem in server'));
				Log::Instance()->add(Log::ERROR, $e);
		}
		if($success) {
			
			Notice::add(Notice::SUCCESS, __('Profile updated successfully'));
			$this->_redirectUrl(App::helper('url')->getAccountUrl('account/edit',$query));
		}
		$this->_redirectUrl(App::helper('url')->getAccountUrl('account/edit',$query));
		return $this;
    }
    
    /* Country based city Change */
	public function action_getcity()
	{
		$this->auto_render = false;
		$this->loadBlocks('account');
		$country = $this->getRequest()->query('country_id');
		$city = $this->getRequest()->query('city_id');
		$area = $this->getRequest()->query('area_id');
		$output = $this->getBlock('city')->setCountryId($country)->setCityId($city)->setAreaId($area)->toHtml();
		$this->getResponse()->body($output); 
	}
	
	/* city based area Change */
	public function action_getarea()
	{
		$this->auto_render = false;
		$this->loadBlocks('account');
		$city = $this->getRequest()->query('city_id');
		$area = $this->getRequest()->query('area_id');
		$output = $this->getBlock('area')->setCityId($city)->setAreaId($area)->toHtml();
		$this->getResponse()->body($output); 
	}
	
	public function action_getclinics()
	{
		$clinics = App::model('clinic',false)->setConditionalLanguage(true)->setLanguage(App::getCurrentLanguageId())->selectAttributes(array('clinic_name','type'))->filter('clinic_status',array('=',1));
		if($this->getRequest()->query('q')) {
			$clinics->filter('clinic_name',array('like','%'.$this->getRequest()->query('q').'%'));
		}
		$clinics->getSelect()->limit(10);
		$collection = $clinics->loadCollection();
		$clinicset = array();
		foreach($collection as $c) { 
			$clinicset[] = array('clinic_id' => $c->getId(),'clinic_name' => $c->getClinicName(),'clinic_text' => $c->getTypeText(),'clinic_type' => $c->getType());
		}
		$this->getResponse()->body(json_encode($clinicset)); 
	}
	
	public function action_getdepartmentlists()
	{
		$dep_lists = App::model('core/department')->getDepartment($this->getRequest()->query('q'));
		$this->getResponse()->body(json_encode($dep_lists));
	}
	
	public function action_welcome() 
	{
		$this->loadBlocks('account');
		$this->getBlock('head')->setTitle(App::getConfig('META_TITLE',Model_Core_Place::ADMIN))
								->setTitle(__('Book health appointments in seconds'));
		$this->getBlock('content')->unsetChild('breadcrumbs');
		$this->renderBlocks();
	}
	
	
}
