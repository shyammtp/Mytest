<?php defined('SYSPATH') or die('No direct script access.'); 

class Controller_Settings extends Controller_Account {
	
	public function action_save()
	{
		$this->_initUsers();
		$this->_checkLogin();
		$request = $this->getRequest(); 
		$this->_getUser()->addSettings('APPOINTMENT_ACCEPT',Arr::get($request->post(),'appt_status',"0"));   
		$this->_getUser()->addSettings('EMAIL_APP_NOTIFICATION',Arr::get($request->post(),'email_notification',"0"));
		Notice::add(Notice::SUCCESS,__('Your settings updated'));
		$this->_redirectUrl(App::helper('url')->getAccountUrl('account/settings'));
	}
	
	public function action_settimings()
	{ 
		$this->_initUsers();
		$this->_checkLogin();
		$this->_onlyForDoctor();
		$success = false;
		$session = App::model('core/session');
		$model = App::model('core/timings',false);
		$request = $this->getRequest();
		$query = $request->query(); 
		$timings = $model->collectTimings($request->post());
		try {
			$errors = $model->validateTimes($timings); 
			$dayweek = $model->getDaysWeekArray();
			if(empty($errors)) {
				$model->setEntityTypeId(Model_User::ENTITY_TYPE_ID)->setEntityId($this->_getUser()->getId())->deleteTimings();
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
				$this->_getUser()->setAppointmentDuration($request->post('appointment_duration'));
				$this->_getUser()->save();
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
		$this->_redirectUrl(App::helper('url')->getAccountUrl('account/timings',$query)); 
	}
	
	public function action_addvideo()
	{
		$this->_initUsers();
		$this->_checkLogin();
		$this->_onlyForDoctor();
		
		$success = false;
		$session = App::model('core/session');
		$request = $this->getRequest();
		if($request->post('videopost') == 1){
			$query = $request->query();
			try {
				$this->_getUser()->ValidateVideos($request->post());
				$this->_getUser()->setVideoTitle($request->post('title'))->setVideoDescription($request->post('description'))->addVideo($request->post('video')); 
				$success = true;
			} catch(Validation_Exception $ve) {
					$session->setDatas('form_data',array('video' => $request->post()));
					Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true)); 
			} catch(Exception $e) {
				Notice::add(Notice::ERROR, $e->getMessage());
			}
			if($success) {  
				Notice::add(Notice::SUCCESS, __('Video added'));
			}
		}  
		$this->_redirectUrl(App::helper('url')->getAccountUrl('account/media',$query)); 
	}
	
	public function action_deletevideo()
	{
		$this->_initUsers();
		$this->_checkLogin();
		$this->_onlyForDoctor();
		$success = false;
		$session = App::model('core/session');
		$request = $this->getRequest();
		$query = $request->query();
		try {
			if(!isset($query['vid'])) {
				throw new Kohana_Exception(__('Invalid Video'));
			}
			$this->_getUser()->removeVideo($query['vid']); 
			$success = true;
		} catch(Exception $e) {
			Notice::add(Notice::ERROR, $e->getMessage());
		}
		if($success) {  
			Notice::add(Notice::SUCCESS, __('Video Removed'));
		}
		unset($query['vid']);
		$this->_redirectUrl(App::helper('url')->getAccountUrl('account/media',$query));
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
	
	public function action_appointment()
	{
		$request = $this->getRequest(); 
		$query = $request->query();
		$model = App::model('core/appointments',false)->load(Arr::get($query,'apptid'),'reference_id');
		if($request->post('is_reject')){
			$model->setReportMessage($request->post('reject_reason'))->setState(Model_Core_Appointments::STATE_REJECT);
			Notice::add(Notice::SUCCESS,__('This appointment has been rejected'));
		}
		if($request->post('accept')){
			$model->setReportMessage(__('This appointment has been accepted'))->setState(Model_Core_Appointments::STATE_ACCEPT);
			Notice::add(Notice::SUCCESS,__('This appointment has been accepted'));
		} 
		$this->_redirectUrl(App::helper('url')->getAccountUrl('account/viewappointments',$query));
	}
	
	public function action_editbook()
	{ 
		$request = $this->getRequest();
		$query = $request->query();
		$data = $request->post(); 
		$oldappt = App::model('core/appointments',false)->load(Arr::get($query,'apptid'),'reference_id');	
		$data['user_id'] = $oldappt->getUserId();
		$response = array();
		$response['errors'] = array();$response['error'] = false;$response['success'] = false;
		if(!$request->post('name')) {
			$response['errors']['name'] = __('Name Must not empty');
		}
		if(!$request->post('description')) {
			$response['errors']['description'] = __('Description Must not empty');
		}
		if(count($response['errors'])) {
			$response['error'] = true;
		} else {
			try {
				$oldappt->addData($data)->setNoValidationCheck(true)->setDoctor($oldappt->getDoctor());
				$oldappt->saveAppointment();
				$oldappt->setState(Model_Core_Appointments::STATE_EDIT);				 
				$response['success'] = true;
				$response['error'] = false;
			} catch(Kohana_Exception $e) {
				$response['errors']['server'] = $e->getMessage();
			}
		}
		if(count($response['errors'])) {
			$response['error'] = true;
		}
		$this->getResponse()->body(json_encode($response));
	}
	
	public function action_rotatebook()
	{ 
		$request = $this->getRequest();
		$query = $request->query();
		$data = $request->post();
		$oldappt = App::model('core/appointments',false)->load(Arr::get($query,'apptid'),'reference_id');
		$newdate = $request->post('rotate_date');
		$data['user_id'] = $oldappt->getUserId();
		$data['name'] = $oldappt->getName();
		$data['description'] = $oldappt->getComments();
		if($request->post('rotate_reason')) {
			$data['description'] .= "-----".$request->post('rotate_reason')." by ".$oldappt->getDoctor()->getFullName();
		}
		$data['datetime'] = ($newdate ? $newdate : $oldappt->getReadableTime('Y-m-d'))." ".$request->post('times');
		$newdoctor = App::model('user',false)->load($request->post('rotate_doctor'));
		
		try {			
			if(!$request->post('times') || !$request->post('rotate_doctor')) { 
				throw new Kohana_Exception(__('Invalid Time / Doctor')); 
			}
			if(!$newdoctor->hasSubscribed()) {
				throw new Kohana_Exception(__('Invalid Doctor'),NULL,20);
			}
			$model = App::model('core/appointments',false)->addData($data)->setDoctor($newdoctor);
			$model->saveAppointment(); 
			$oldappt->setRotateAppointmentId($model->getId())->setReportMessage($request->post('rotate_reason'))->setState(Model_Core_Appointments::STATE_ROTATE);				 
			Notice::add(Notice::SUCCESS, __('Appointment has been to rotated to another doctor (:doctor_name)',array(':doctor_name' => $newdoctor->getFullName())));
		} catch(Kohana_Exception $e) {
			Notice::add(Notice::ERROR, $e->getMessage());
		} 
		$this->_redirectUrl(App::helper('url')->getAccountUrl('account/viewappointments',$query));
	} 
}
