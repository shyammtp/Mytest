<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Store_Users extends Controller_Core_Store {

    protected $_user;
	const USERS_SIGNUP_EMAIL_TEMPLATE = 8;
	const USERS_WELCOME_EMAIL_TEMPLATE = 9;
	public function preDispatch()
	{
		$this->_noAccessCheckAction = array('editprofile','viewprofile','saveprofile','additionalemaildata','additionaldata','postadditional','postadditionalemail','deleteadditionalemail','deleteadditional');
		parent::preDispatch();
	}
	
    protected function _initUsers()
    {
		$id = $this->getRequest()->query('id');
		if(!$id && $this->getRequest()->query('mode'))
		{
		   $session = App::model('store/session');
		   $id = $session->getId();
		}		
        $this->_user = App::model('user',false)->load($id); 
		App::register('users',$this->_user);
        return $this->_user;
    }

    public function action_index()
    {   
		$this->loadBlocks('users');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(__('Doctors'));
		$contentblock->setPageTitle(__('Doctors'));
		$this->renderBlocks();
    }
    

    public function action_edit()
    { 
		$this->_initUsers();
		$session = App::model('store/session');
		$this->loadBlocks('users');
		$user = App::model('user',false);
		$usermodel = App::model('user',false)->load($this->getRequest()->query('id'));
		$breadcrumb = $this->getBlock('breadcrumbs');
		$contentblock = $this->getBlock('content');
		if($this->getRequest()->query('id')) {
			$user->loadByAllLanguages($this->getRequest()->query('id'));
			$user->setVideo(array());
			if($session->getFormData()) { 
				$this->_localSessionData(); 
				$user->addData($session->getFormData()); 
				$session->unsetData('form_data');
			}
			$user->unsetData('timeerror');
			if($session->getTimeerror()) {
				$user->setTimeError($session->getTimeerror());
				$session->unsetData('timeerror');
			}
			if(!$user->getUserToken()) { 
				$usertoken = sha1(uniqid(Text::random('alnum', 32).$user->getId(), TRUE));
				$user->setUserToken($usertoken);
			} 
			if(!$user->getUserToken()) { 
				$usertoken = sha1(uniqid(Text::random('alnum', 32).$user->getId(), TRUE));
				$user->setUserToken($usertoken);
			} 
			if(!$user->getUserId()) {
				Notice::add(Notice::ERROR, __('Invalid User'));
				$this->_redirect('users/index');
			}
			if($usermodel->getUserId() != $this->getRequest()->query('id')) {
				Notice::add(Notice::ERROR, __('Invalid User'));
				$this->_redirect('users/index');
			}
			if($usermodel->getUserType() != $this->getRequest()->query('name')) {
				Notice::add(Notice::ERROR, __('Invalid User'));
				$this->_redirect('users/index');
			}
			$breadcrumb->addCrumb('editusers',array('label' => __('Edit - :user',array(':user' => $usermodel->getFullName())),
												'title' => __('Edit - :user',array(':user' => $usermodel->getFullName()))
							));
			$this->getBlock('head')->setTitle(__('Edit Doctor - :user',array(':user' => $usermodel->getFullName())));
			$contentblock->setPageTitle('<i class="fa fa-user" ></i>&nbsp;'.__('Edit Doctor - :user',array(':user' => $usermodel->getFullName())));
			} else {
				if($session->getFormData()) { 
					$this->_localSessionData();
					$user->addData($session->getFormData()); 
					$session->unsetData('form_data');
				}
				if(!$user->getUserToken()) { 
					$usertoken = sha1(uniqid(Text::random('alnum', 32).$user->getId(), TRUE));
					$user->setUserToken($usertoken);
				} 
				$breadcrumb->addCrumb('addusers',array('label' => __('Add New Doctor'),
													'title' => __('Add New Doctor')
								));
				$this->getBlock('head')->setTitle(__('New Doctor'));
				$contentblock->setPageTitle('<i class="fa fa-user" ></i>&nbsp;'.__('New Doctor'));
			}
			App::register('users',$user);
			$this->getBlock('doctor_edit')->setUsers($user);
			$this->getBlock('gallery')->setUsers($user);
			$this->getBlock('general')->setUsers($user);
			//$this->getBlock('patient_edit')->setUsers($user);
			$this->getBlock('admin_edit')->setUsers($user);
			$this->renderBlocks();
    }
	
	public function _localSessionData()
	{
		$session = App::model('store/session');
		$data = $session->getFormData();
		if(isset($data['password'])) {
			unset($data['password']);
		}
		 
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
		if(isset($data['deparment_id'])) { 
			$exp = array_filter(explode(',',$data['deparment_id']));
			$data['departments'] = App::model('core/department')->getDepartmentByIds($exp);
		}
		if(isset($data['clinic_id'])) { 
			$exp = array_filter(explode(',',$data['clinic_id']));
			$data['clinics'] = App::model('clinic')->getClinicByIds($exp);
		}
		$session->setDatas('form_data',$data);
	}

    public function action_save()
    {
		$this->_initUsers();
		$request = $this->getRequest();
		$data = $request->post();	
		$session = App::model('store/session');
		$language = App::model('core/language')->getLanguages();
		$success = false;
		$errors = array();
			$query = $this->getRequest()->query();
			if($this->getRequest()->query('return_url')) {
				$query['return_url'] = urldecode($this->getRequest()->query('return_url'));
			}
			try {
				$request->post('primary_email_address',strtolower($request->post('primary_email_address')));
				$password = "";
				if($request->post('user_password')) {
					$password = $request->post('user_password');
					$this->getUser()->setData('password',md5($request->post('user_password')));
				}
				$status = $request->post('status') ? true: false;
				$this->getUser()->setData('status',$status);
				$dob=App::helper('date')->is_validdate($request->post('date_of_birth'));
				$request->post('date_of_birth',$dob);
				$this->getUser()->addData($request->post());
		if($request->post('user_group_id')){
				$user_group_ids=implode(",",$request->post('user_group_id'));
				$this->getUser()->setData('user_group_id',$user_group_ids);
		}
		$this->getUser()->validate();
		 
		if(!$this->getRequest()->query('id')) {
			$this->getUser()->setCreatedDate(date("Y-m-d H:i:s"));
			$this->getUser()->setUpdatedDate(date("Y-m-d H:i:s"));
		} else {
			$this->getUser()->setUpdatedDate(date("Y-m-d H:i:s"));
		}
		$verification_key = Text::random('alnum',12);
		$this->getUser()->setVerificationKey($verification_key)->setMobile($request->post('mobile'))->setCountry($request->post('country_id'))->setCity($request->post('city_id'))->setUserType($this->getRequest()->query('name'));
		if($request->post('area_id')){ $this->getUser()->setArea($request->post('area_id')); }
		//$this->getUser()->setAbout($request->post('about'));
		//$this->getUser()->setVenue($request->post('venue'));
		$this->getUser()->saveUser(); 
		$success = true;
		$customers = App::model('user')->load($request->post('primary_email_address'),'primary_email_address');
		$session->unsetData('form_data');
		} catch(Validation_Exception $ve) {
				$session->setDatas('form_data',$request->post());
				Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true));
				$errors = $ve->array->errors('validation',true);
		} catch(Kohana_Exception $ke) {
				print_r($ke);exit;
				Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$ke->getMessage())));
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
				print_r($e);exit;
				Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$e->getMessage())));
		Log::Instance()->add(Log::ERROR, $e);
		}
		if($success) {
			if($customers->getProfilePercentage() == 0){
				Notice::add(Notice::SUCCESS, __('User information has been updated successfully'));
			}else{
				Notice::add(Notice::SUCCESS, __('User Information Updated'));
			}
			if(isset($query['return_url']) && $query['return_url']) {
				$this->_redirectUrl(urldecode($query['return_url']));
			}
			$this->_redirect('users/index',$query);
		}
		$this->_redirect('users/edit',$query);
		return $this;
    }

    public function getUser()
    {
        return $this->_user;
    }

    
    public function action_userlist()
    { 
	    $this->loadBlocks('users');
	    $user = App::model('user');
	    if($this->getRequest()->query('selected_user')) {
		    $user->load($this->getRequest()->query('selected_user'));
	    }
	    $this->getBlock('content')
		    ->setReturnUrl($this->getRequest()->query('return_url'))
		    ->setUser($user);
	    $this->renderBlocks();
    }

    public function action_view()
    {
	    $this->_initUsers();
	    if(!$this->getUser()->getUserId()) {
		    $this->_redirect('users/index');
	    }
	    $this->loadBlocks('users');
	    $breadcrumb = $this->getBlock('breadcrumbs');
	    $breadcrumb->addCrumb('viewuser',array('label' => __('View - :user',array(':user' => $this->getUser()->getPrimaryEmailAddress())),
											    'title' => __('View - :user',array(':user' => $this->getUser()->getPrimaryEmailAddress()))
						    ));
	    $this->getBlock('head')->setTitle(__('View User - :user',array(':user' => $this->getUser()->getPrimaryEmailAddress())));
	    $this->getBlock('content')->setPageTitle('<i class="fa fa-user" ></i>&nbsp;'.__('View User - :user',array(':user' =>  $this->getUser()->getPrimaryEmailAddress())));
	    $this->renderBlocks();
    }
    
    public function action_editprofile()
    { 
		$this->_initUsers();
		$session = App::model('store/session');
		$this->loadBlocks('users');
		$user = App::model('user',false)->setData($session->getFormData());
		$breadcrumb = $this->getBlock('breadcrumbs');
		$contentblock = $this->getBlock('content'); 
		$id = $session->getId();
		
		if(!$id) {
			Notice::add(Notice::ERROR, __('Invalid User'));
			$this->_redirect('dashboard/index');
		}
		if($id) {
			
			$user->loadByAllLanguages($id);
			if(!$user->getUserToken()) { 
			$usertoken = sha1(uniqid(Text::random('alnum', 32), TRUE));
			$user->setUserToken($usertoken);
			}
			$user->setMode('epf');
			if(!$user->getUserId()) {
			Notice::add(Notice::ERROR, __('Invalid User'));
			$this->_redirect('dashboard/index');
			}
			$breadcrumb->addCrumb('editusers',array('label' => __('Edit - :user',array(':user' => $user->getPrimaryEmailAddress())),
												'title' => __('Edit - :user',array(':user' => $user->getPrimaryEmailAddress()))
							));
			$this->getBlock('head')->setTitle(__('Edit User - :user',array(':user' => $user->getPrimaryEmailAddress())));
			$contentblock->setPageTitle('<i class="fa fa-user" ></i>&nbsp;'.__('Edit User - :user',array(':user' => $user->getPrimaryEmailAddress())));
		} else {
			$breadcrumb->addCrumb('addusers', array('label' => __('Add New User'),
							'title' => __('Add New User')
							));
			$this->getBlock('head')->setTitle(__('New User'));
			$contentblock->setPageTitle('<i class="fa fa-user" ></i>&nbsp;'.__('New User'));
		} 
		$this->getBlock('users_edit_wrapper')->setUsers($user);
		$this->renderBlocks();
    }
    
    public function action_saveprofile()
    { 
		$request = $this->getRequest();
		$session = App::model('store/session');
		$language = App::model('core/language')->getLanguages();
		$user = App::model('user',false);
		$success = false;
		$id = $session->getId();
		$user->loadByAllLanguages($id);
		$post = $request->post();
		
		$errors = array();
			$query = $this->getRequest()->query();
			if($this->getRequest()->query('return_url')) {
				$query['return_url'] = urldecode($this->getRequest()->query('return_url'));
			}
			try {
				if($request->post('user_password')) {
					$user->setData('password',md5($request->post('user_password')));
				}
				$status = $request->post('status') ? true: false;
				$user->setData('status',$status);
				$isverified = $request->post('is_verified') ? true: false;
				$user->setData('is_verified',$isverified);
				$dob=App::helper('date')->is_validdate($request->post('date_of_birth'));
				$request->post('date_of_birth',$dob);
				$post['date_of_birth'] = $dob;
		$user->addData($post); 
		$user->validate();
		if(!$id) {
			$user->setCreatedDate(date("Y-m-d H:i:s"));
			$user->setUpdatedDate(date("Y-m-d H:i:s"));
		} else {
			$user->setUpdatedDate(date("Y-m-d H:i:s"));
		}
		$user->saveUser(); 
		$success = true;
				$session->unsetData('form_data');
		} catch(Validation_Exception $ve) {
				$session->setDatas('form_data',$request->post());
				Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true));
				$errors = $ve->array->errors('validation',true);
		} catch(Kohana_Exception $ke) {
				Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$e->getMessage())));
				Log::Instance()->add(Log::ERROR, $ke);
		} catch(Exception $e) {
				Notice::add(Notice::ERROR, __('Problem in server. try again later (:message)',array(":message"=>$e->getMessage())));
				Log::Instance()->add(Log::ERROR, $e);
		}
			if($success) {
				Notice::add(Notice::SUCCESS, __('User Information Updated'));
				if(isset($query['return_url']) && $query['return_url']) {
					$this->_redirectUrl(urldecode($query['return_url']));
				}
				$this->_redirect('users/editprofile',array('user'=> Encrypt::instance()->encode($id), 'mode' => 'epf')); 
			}
		$this->_redirect('users/editprofile',array('user'=> Encrypt::instance()->encode($id), 'mode' => 'epf'));
		return $this;
    }
	
	public function action_viewprofile()
    { 
		$session = App::model('admin/session');
		$id = $session->getId();
		$user = App::model('user',false);
		$user->load($id);
	    if(!$user->getUserId()) {
		    $this->_redirect('admin/dashboard/index');
	    }
	    $this->loadBlocks('users');
	    $breadcrumb = $this->getBlock('breadcrumbs');
	    $breadcrumb->addCrumb('viewuser',array('label' => __('View - :user',array(':user' => $user->getPrimaryEmailAddress())),
											    'title' => __('View - :user',array(':user' => $user->getPrimaryEmailAddress()))
						    ));
	    $this->getBlock('head')->setTitle(__('View User - :user',array(':user' => $user->getPrimaryEmailAddress())));
	    $this->getBlock('content')->setPageTitle('<i class="fa fa-user" ></i>&nbsp;'.__('View User - :user',array(':user' =>  $user->getPrimaryEmailAddress())));		
	    $user->setMode('epf');
		App::register('users',$user);
	    $this->renderBlocks();
    }
    
        /**
	 * Handle GET requests.
	 */
	public function action_list()
	{
		$this->auto_render=false;
        $model = App::model('user');
		$term = '';
		if($this->getRequest()->query('term')) {
			$term = $this->getRequest()->query('term');
		}
		try
		{
            $options = array();
            foreach($model->getCustomerByKeyword('primary_email_address',$term) as  $optio)
            {
                $options[] = array('label' => $optio->getData('primary_email_address')." (".$optio->getData('first_name').")" , 'value' => $optio->getData('user_id'));
            }
			echo json_encode(array('datas' => $options));
			
		}
		catch (Kohana_HTTP_Exception $khe)
		{
			return;
		}
		catch (Kohana_Exception $e)
		{
			throw $e;
		}
	}
	
	public function action_loadactivityajax()
    {
	    $user = $this->_initUsers();
	    $this->loadBlocks('users');
		$request = $this->getRequest();
		$page = $request->post('page');
		if(!$page || $page <= 0) {
			$page = 2;
		}
		$offset = ($page - 1) * 20 + 1;
		$actvity =  App::model('user/activity',false)->getActivity($user->getId(),20,$offset);
		 
	    $this->getBlock('content')->setPage($page)->setUsers($user)->setActivity($actvity);
	    $this->renderBlocks();
    }
    
    public function action_ajaxlist()
	{
		$this->loadBlocks('users');
		$output=$this->getBlock('listing')->toHtml();
		$this->getResponse()->body($output);
	}
	
	public function action_uploadgallery()
	{
		$json = array();
		$filename = NULL; 
        if ($this->request->method() == Request::POST)
        {
            if (isset($_FILES['gallery_image']))
            {
				$uploaddir = 'uploads/user'.DIRECTORY_SEPARATOR.$this->getRequest()->query('id');
				if(!file_exists(DOCROOT.$uploaddir)) {
					mkdir(DOCROOT.$uploaddir,0777,true);
				}
                $filename = $this->_save_image($_FILES['gallery_image'],DOCROOT.$uploaddir);
				$json['file'] = basename($filename);
				$model = App::model('user/gallery')->setUserId($this->getRequest()->query('id'))
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
            ! Upload::type($image, array('jpg', 'jpeg', 'png', 'gif')))
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
			$userId = $request->query('id');
			$delete = DB::delete(App::model('user/gallery')->getTableName())->where('file','=',$image)->where('user_id','=',$userId)
						->execute(App::model('user/gallery')->getDbConfig());
			if(file_exists(DOCROOT.$image)) {
				unlink(DOCROOT.$image);
			}
			$json['success'] = true;
		}
		$this->getResponse()->body(json_encode($json));
	}
	
	public function action_setthumbnail()
	{
		$json = array();
		$request = $this->getRequest();
		$json['success'] = false;
		if($request->query('image')) {
			$image = base64_decode($request->query('image'));
			$userId = $request->query('id');
			DB::update(App::model('user/gallery')->getTableName())->set(array('thumbnail' => 0))->where('user_id','=',$userId)
						->execute();
			$update = DB::update(App::model('user/gallery')->getTableName())->set(array('thumbnail' => 1))->where('file','=',$image)->where('user_id','=',$userId)->execute();
			$json['success'] = true;
		}
		$this->getResponse()->body(json_encode($json));
	}
	  
	
	public function action_settimings()
	{
		$this->_initUsers();
		$success = false;
		$session = App::model('store/session');
		$model = App::model('core/timings',false);
		$request = $this->getRequest();
		$query = $request->query(); 
		$timings = $model->collectTimings($request->post());
		
		try {
			$errors = $model->validateTimes($timings); 
			$dayweek = $model->getDaysWeekArray();
			if(empty($errors)) {
				$model->setEntityTypeId(Model_User::ENTITY_TYPE_ID)->setEntityId($this->getUser()->getId())->deleteTimings();
				foreach($timings as $key => $value) { 
					$model->setDayWeek(Arr::get($dayweek,$key))
							->setStartTime(Arr::get($value,'start_time'))
							->setEndTime(Arr::get($value,'end_time'))
							->setSecondShiftStatus(Arr::get($value,'second_shift_status',0))
							->setShiftStartTime(Arr::get($value,'shift_start_time'))
							->setShiftEndTime(Arr::get($value,'shift_end_time'));
					
					$model->save(); 
					$model->unsetData('day_week')
								->unsetData('start_time')
								->unsetData('end_time')
								->unsetData('second_shift_status')
								->unsetData('shift_start_time')
								->unsetData('shift_end_time'); 
							
				}
				$this->getUser()->setAppointmentDuration($request->post('appointment_duration'));
				$this->getUser()->save();
				$success = true;
			} else {
				Notice::add(Notice::ERROR, __('Fix the errors below.'));
				$session->setDatas('timeerror',$errors)
						->setDatas('form_data',$request->post());
				$query['timeerror'] = 1;
			}
		} catch (Exception $e) {
			
		}
		if($success) { 
			$query['timeerror'] = 0;
			Notice::add(Notice::SUCCESS, __('Timing has been updated'));
		}
		$this->_redirect('users/edit',$query); 
	}
	
	public function action_addvideo()
	{
		$this->_initUsers();
		$success = false;
		$session = App::model('admin/session');
		$request = $this->getRequest();
		$query = $request->query();
		try {
			$this->getUser()->ValidateVideos($request->post());
			$this->getUser()->setVideoTitle($request->post('title'))->setVideoDescription($request->post('description'))->addVideo($request->post('video')); 
			$success = true;
		} catch(Validation_Exception $ve) {
				$session->setDatas('form_data',array('video' => $request->post()));
				Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true));
				//$errors = $ve->array->errors('validation',true);
		} catch(Exception $e) {
			Notice::add(Notice::ERROR, $e->getMessage());
		}
		if($success) {  
			Notice::add(Notice::SUCCESS, __('Video added'));
		}
		$this->_redirect('admin/users/edit',$query); 
	}
	
	public function action_deletevideo()
	{
		$this->_initUsers();
		$success = false;
		$session = App::model('admin/session');
		$request = $this->getRequest();
		$query = $request->query();
		try {
			if(!isset($query['vid'])) {
				throw new Kohana_Exception(__('Invalid Video'));
			}
			$this->getUser()->removeVideo($query['vid']); 
			$success = true;
		} catch(Exception $e) {
			Notice::add(Notice::ERROR, $e->getMessage());
		}
		if($success) {  
			Notice::add(Notice::SUCCESS, __('Video Removed'));
		}
		unset($query['vid']);
		$this->_redirect('admin/users/edit',$query); 
	}
	
	public function action_getclinics()
	{
		$doctors = App::model('clinic',false)->selectAttributes(array('clinic_name','primary_email_address','type'))->filter('clinic_status',array('=',1));
		if($this->getRequest()->query('q')) {
			$doctors->filter('clinic_name',array('like','%'.$this->getRequest()->query('q').'%'));
		}
		$doctors->getSelect()->limit(10);
		$collection = $doctors->loadCollection();
		$doctorset = array();
		foreach($collection as $c) { 
			$doctorset[] = array('clinic_id' => $c->getId(),'clinic_name' => $c->getClinicName(),'clinic_text' => $c->getTypeText());
		}
		$this->getResponse()->body(json_encode($doctorset)); 
	}
	
	public function action_exportexcel()
	{
		$date = str_replace(" ","_",Date::formatted_time());
		$fileName   = 'Users_'.$date.'.xls';
		$this->loadBlocks('users'); 
		$output = $this->getBlock('userslist')->getCsvFile();
		$this->_prepareDownloadResponse($fileName, $output);
	}
	
	public function action_massdeleteuser()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		$usermodel = App::model('user');
		$count_arr = explode(',',$data['user_id']);
		$result = $usermodel->massDeleteUsers($count_arr);
		if($result > 1):
			Notice::add(Notice::SUCCESS, __(':count user details has been deleted successfully',array(':count' => $result)));
			$this->_redirect('users/index');
		endif;
		Notice::add(Notice::SUCCESS, __('User detail has been deleted successfully'));
		$this->_redirect('users/index');
	}
	
}
