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
class Model_Api_Profile extends Model_RestAPI {
	
	private $_offset;
	private $_select;
	private $_firstPage = 1;
	private $_lastPage;
    private $_totalItem = 0;
	private function _getUser()
	{ 
		if(!$this->hasData("current_user")) {
			$model = App::model('user',false);
			if(Arr::get($this->params,'user_id')) {
				$model->load(Arr::get($this->params,'user_id'));
			}
			$this->setData("current_user",$model);
		}
		return $this->getData("current_user");
	}
	
	private function _getDoctor()
	{
		if(!$this->hasData("current_doctor")) {
			$model = App::model('user',false);
			if(Arr::get($this->params,'doctor_id')) {
				$model->load(Arr::get($this->params,'doctor_id'));
			}
			$this->setData("current_doctor",$model);
		}
		return $this->getData("current_doctor");	
	}
	
	private function  _onlyforDoctor()
	{
		if(!$this->_getUser()->isDoctor()) {
			throw new Kohana_Exception(__('Invalid Page'),NULL,20);
		} 
	}
	
	public function getTimings()
	{
		$timings = $this->_getUser()->getTimings();
		return array('times' => $timings,'appointment_duration' => $this->_getUser()->getAppointmentDuration()); 
	}
	
	private function _parseParams()
	{
		$data = array();
		if(!is_array(Arr::get($this->params,'timings',''))){
			$timings = json_decode(Arr::get($this->params,'timings',''));
			$data['timings'] = $timings;
		}
		if(!is_array(Arr::get($this->params,'second_shift',''))){
			$secondshift = json_decode(Arr::get($this->params,'second_shift',''));
			$data['second_shift'] = $secondshift;
		}
		return $data;
	}
	
    public function updateTimings()
	{
		$this->_onlyforDoctor();
		$model = App::model('core/timings',false); 
		$da = $this->_parseParams();
		$this->params = Arr::merge($this->params,$da); 
		$timings = $model->collectTimings($this->params);
		$response = array();
		$response['success'] = false;
		try {;
			$errors = $model->validateTimesException($timings);
			$dayweek = $model->getDaysWeekArray();
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
			if(Arr::get($this->params,'appointment_duration')) {
				$this->_getUser()->setAppointmentDuration(Arr::get($this->params,'appointment_duration'));
				$this->_getUser()->save();
			}
			$response['success'] = true;
			$response['times'] = $this->_getUser()->getTimings();
		} catch (Kohana_Exception $e) {
			throw $e;
		}
		return $response;
	}
	
	public function addphotos()
	{
		$this->_onlyforDoctor();
		$files = $_FILES; 
		$json = array();
		$filename = NULL;
		if (isset($files['image']))
		{
			$uploaddir = 'uploads/user'.DIRECTORY_SEPARATOR.$this->_getUser()->getId();
			if(!file_exists(DOCROOT.$uploaddir)) {
				mkdir(DOCROOT.$uploaddir,0777,true);
			}
			$filename = $this->_save_image($files['image'],DOCROOT.$uploaddir);
			$json['file'] = basename($filename);
			$model = App::model('user/gallery')->setUserId($this->_getUser()->getId())
					->setFile($uploaddir.DIRECTORY_SEPARATOR.basename($filename))
					->setFileType($files['image']['type'])
					->setAddedOn(date("Y-m-d H:i:s"))
					->save();
			 if (!$filename) {
				throw new Kohana_Exception(__('There was a problem while uploading the image.
					Make sure it is uploaded and must be JPG/PNG/GIF file.'));
			}		 
		} 
        return $json;
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
	
	public function deletephotos()
	{
		$this->_onlyforDoctor();
		$image = base64_decode(Arr::get($this->params,'image'));
		$userId = $this->_getUser()->getId();
		$delete = DB::delete(App::model('user/gallery')->getTableName())->where('file','=',$image)->where('user_id','=',$userId)
					->execute();
		if(file_exists(DOCROOT.$image)) {
			unlink(DOCROOT.$image);
		}
		$json['success'] = true;
		return $json;
	}
	
	public function getPhotos()
	{
		$this->_onlyforDoctor();
		$images = $this->_getUser()->getGallerysImages();
		return array('images' => array_values($images));
	}
	
	public function addvideo()
	{
		$this->_onlyforDoctor(); 
		$json = array();
		$json['success'] = false;
		try {
			$this->_getUser()->ValidateVideos($this->params);
			$this->_getUser()->setVideoTitle(Arr::get($this->params,'title'))->setVideoDescription(Arr::get($this->params,'description'))->addVideo(Arr::get($this->params,'video')); 
			$json['success'] = true;
		} catch(Validation_Exception $ve) {
			throw new Kohana_Exception(implode(",",$ve->array->errors('validation',true)),NULL,20);
		}   
		return $json;
	}
	
	public function getVideos()
	{
		$this->_onlyforDoctor();
		$vids = $this->_getUser()->getVideos();
		return array('videos' => array_values($vids));
	}
	
	public function deletevideos()
	{
		$this->_onlyforDoctor(); 
		$json = array();
		$json['success'] = false;
		$vide = Arr::get($this->params,'video');
		if(!$vide) {
			throw new Kohana_Exception(__('Invalid Video'));
		}
		$this->_getUser()->removeVideo(Arr::get($this->params,'video')); 
		$json['success'] = true;
		return $json; 
	}
	
	public function updateSettings()
	{
		$json = array();
		$json['success'] = false;
		if(isset($this->params['appt_status']) && $this->_getUser()->isDoctor()) {
			$this->_getUser()->addSettings('APPOINTMENT_ACCEPT',Arr::get($this->params,'appt_status',"0"));
		}
		if(isset($this->params['email_notification'])) {
			$this->_getUser()->addSettings('EMAIL_APP_NOTIFICATION',Arr::get($this->params,'email_notification',"0"));
		}
		$json['success'] = true;
		return $json; 
	}
	
	public function getAppointments()
	{
		if(Arr::get($this->params,'appt_id')) {
			return $this->getSingleAppointment();
		}
		$this->_select = DB::select()->from(App::model('core/appointments')->getTableName());
		if($this->_getUser()->isDoctor()) {
			$this->_select->where_open()->where('doctor_id','=',$this->_getUser()->getId())
				->or_where('user_id','=',$this->_getUser()->getId())->where_close();
		} else {
			$this->_select->where('user_id','=',$this->_getUser()->getId());
		}
		if(Arr::get($this->params,'date') && strtotime(Arr::get($this->params,'date'))) {
			$this->_select->where('appt_time','>=',Arr::get($this->params,'date')." 00:00:01")
					->where('appt_time','<=',Arr::get($this->params,'date')." 23:59:59");
		}
		if(Arr::get($this->params,'ref_id')) {			
			$this->_select->where_open();
			$this->_select->where('reference_id','like','%'.Arr::get($this->params,'ref_id').'%');
			$this->_select->or_where('name','like','%'.Arr::get($this->params,'ref_id').'%');	
			$this->_select->where_close();
		}
		$this->_getTotalItem(); 
		$this->_select->order_by('appointment_id','desc');
        $this->_select->limit($this->_getPerPage())
				->offset($this->_getOffset()); 
		$result = $this->_select->execute();
		$data = array();
		foreach($result as $s) {
			$appmodel = App::model('core/appointments',false)->setData($s);
			$patient = $appmodel->getPatient();
			$doctor = $appmodel->getDoctor();
			$s['patient_appointment'] = false; 
			if($this->_getUser()->getId() == Arr::get($s,'user_id')) {
				$s['patient_appointment'] = true;
			}
			$s['patient'] = array('booked_patient_name' => $appmodel->getName());
			$s['doctor'] = array('doctor_name' => $doctor->getFullName());
			$s['appt_time_formatted'] = $appmodel->getReadableTime();
			$s['disabled_status'] = ($appmodel->getApptTime() < Date::formatted_time());
			$data[] = $s;		
		}
		return array('results' => $data,'totalitem' => $this->_totalItem);
	}
	
	public function getDoctorLists()
	{
		if(!Arr::get($this->params,'name')) {
			return array('results' => array());
		}
		$select = App::model('user',false)->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->selectAttributes(array('first_name','social_title'))
					->filter('user_id',array('not in', (array) $this->_getUser()->getId()))
					->filter('user_type',array('=', Model_User::DOCTOR))
					->limit(10);
		if(Arr::get($this->params,'name')) {
			$select->filter('first_name',array('like','%'.Arr::get($this->params,'name').'%'));
		}
		$data = array();
		foreach($select->loadCollection() as $s) {
			$doctors = array();
			$doctors['id'] = $s->getId();
			$doctors['name'] = $s->getFullName();
			$data[] = $doctors;
		}
		return array('results' => $data);
	}
	
	public function getSingleAppointment()
	{
		$appt = App::model('core/appointments',false)->load(Arr::get($this->params,'appt_id'),'reference_id');
		$appointment = array();
		if($appt->getId()) {
			$appointment = $appt->getData();
			$patient = $appt->getPatient();
			$doctor = $appt->getDoctor();
			$appointment['patient_appointment'] = false; 
			if($this->_getUser()->getId() == Arr::get($appointment,'user_id')) {
				$appointment['patient_appointment'] = true;
			}
			$appointment['appt_time_formatted'] = $appt->getReadableTime();
			$appointment['patient'] = array('booked_patient_name' => $patient->getFullName());
			$appointment['doctor'] = array('doctor_name' => $doctor->getFullName());
			$appointment['disabled_status'] = ($appt->getApptTime() < Date::formatted_time());
		}
		return array('appointment' => $appointment);
	}
	
	public function _getTotalItem()
    { 
        if(!$this->_totalItem) { 
			$pagination_query = clone $this->_select;
            $q =  $pagination_query->resetSelect()->resetSelect('order')->select(DB::expr('COUNT(*) AS mycount'))->execute()->current();
			$this->_totalItem = Arr::get($q,'mycount',0); 
        }
        return $this->_totalItem;        
    } 
	
	private function _getOffset()
    { 
        $this->_offset  = (int) (($this->_getCurrentPage() - 1) * $this->_getPerPage());
        if( $this->_offset < 0) {
             $this->_offset = 0;
        }
        return  $this->_offset;
    }
    
    private function _getCurrentPage()
    {
        $currentpage = Arr::get($this->params,'page',1);
        if(!$currentpage || $currentpage < 1) {
            return $this->_firstPage;
        }
		 
        if($currentpage > $this->_getLastPage()) {
            $currentpage = $this->_getLastPage();
        }  
        return $currentpage;
    }
	
	private function _getLastPage()
    { 
        $this->_lastPage = ceil($this->_getTotalItem()/$this->_getPerPage());
        return $this->_lastPage;
    }
    
    
    private function _getPerPage()
	{
		return Arr::get($this->params,'limit',10);
	}
	
	public function updateAppointment()
	{ 
		$json = array();
		$json['success'] = false;
		$model = App::model('core/appointments',false)->load(Arr::get($this->params,'appt_id'),'reference_id');
		 
		if(!Arr::get($this->params,'is_edit') && $this->_getUser()->getId() != $model->getDoctor()->getId()) {
			throw new Kohana_Exception(__('Invalid User to modify the appointment'),NULL, 20);
		}
		if(Arr::get($this->params,'is_reject')){
			$model->setReportMessage(Arr::get($this->params,'reject_reason'))->setState(Model_Core_Appointments::STATE_REJECT);
			$json['success'] = true;
		}
		if(Arr::get($this->params,'is_accept')){
			$model->setReportMessage(__('This appointment has been accepted'))->setState(Model_Core_Appointments::STATE_ACCEPT);
			$json['success'] = true;
		}
		if(Arr::get($this->params,'is_edit')){
			$data = $this->params;  
			$data['user_id'] = $model->getUserId();
			$data['doctor_id'] = $model->getDoctorId();
			$data['report_message'] = Arr::get($this->params,'edit_reason');
			try { 
				$model->addData($data)->setNoValidationCheck(true)->setDoctor($model->getDoctor());				 
				$model->saveAppointment();
				$model->setState(Model_Core_Appointments::STATE_EDIT);
				$json['success'] = true;
			} catch(Kohana_Exception $e) {
				throw $e;
			}  
		}
		if(Arr::get($this->params,'is_rotate')){
			$data = array();
			if(!strtotime(Arr::get($this->params,'datetime'))) {
				throw new Kohana_Exception(__('Invalid time'),NULL, 20);
			}
			$data['user_id'] = $model->getUserId();
			$data['name'] = $model->getName();
			$data['description'] = $model->getComments();  
			$data['datetime'] = Arr::get($this->params,'datetime'); 
			$newdoctor = App::model('user',false)->load(Arr::get($this->params,'rotate_doctor'));
			if(!$newdoctor->getId()) {
				throw new Kohana_Exception(__('Invalid Doctor'),NULL,20);
			}
			if(!$newdoctor->hasSubscribed()) {
				throw new Kohana_Exception(__('Invalid Doctor'),NULL,20);
			}
			try {
				$nmodel = App::model('core/appointments',false)->addData($data)->setDoctor($newdoctor);
				$nmodel->saveAppointment(); 
				$model->setRotateAppointmentId($nmodel->getId())->setReportMessage(Arr::get($this->params,'rotate_reason'))->setState(Model_Core_Appointments::STATE_ROTATE);
				$json['success'] = true;
			} catch(Kohana_Exception $e) {
				throw $e;
			}  
		}
		return $json;
	}
	
}	
