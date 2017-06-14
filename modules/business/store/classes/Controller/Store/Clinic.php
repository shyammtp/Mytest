<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Store_Clinic extends Controller_Core_Store {
	protected $_fields = array();
	protected $_clinic;
	public function preDispatch()
	{ 
		$this->_noAccessCheckAction = array('addquickacess');
		parent::preDispatch();
	}
	
	 
	
	protected function _initClinic()
    {
		$id = $this->getRequest()->query('id');
        $this->_clinic = App::model('clinic',false)->load($id);
		
		App::register('clinic',$this->_clinic);
		switch($this->getRequest()->query('type')) {
			
			case Model_Clinic::CLINIC:
					App::register('place_name',__('Clinic'));
				break;
			case Model_Clinic::HOSPITAL:
					App::register('place_name',__('Hospital'));
				break;
			case Model_Clinic::LABS:
					App::register('place_name',__('Labs'));
				break;
			case Model_Clinic::PHARMACY:
					App::register('place_name',__('Pharmacy'));
				break;
			case Model_Clinic::OPTICS:
					App::register('place_name',__('Optics'));
				break;
			default:
				Notice::add(Notice::ERROR,__('Invalid Page'));
				$this->_redirect('admin/clinic/index',array('type' => Model_Clinic::CLINIC));
		}
        return $this->_clinic;
    }
	
	public function getClinic()
    {
        return $this->_clinic;
    }
	
	

	
	/*********** Clinic Management   ************/
	public function action_index()
	{
		$this->_initClinic();
		$this->loadBlocks('clinic');
		$contentblock = $this->getBlock('content');
        $this->getBlock('head')->setTitle(App::registry('place_name'));
		$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.App::registry('place_name'));
		$breadcrumb = $this->getBlock('breadcrumbs');
		$leftmenu = $this->getBlock('leftmenu');
		$breadcrumb->addCrumb('action',array('label' => App::registry('place_name'),
												'title' => App::registry('place_name'))
							);
		switch($this->getRequest()->query('type')) {
			default:
			case Model_Clinic::CLINIC:
					$leftmenu->setActive('medical_places/clinic');
				break;
			case Model_Clinic::HOSPITAL:
					$leftmenu->setActive('medical_places/hospital');
				break;
			case Model_Clinic::LABS:
					$leftmenu->setActive('medical_places/labs');
				break;
			case Model_Clinic::PHARMACY:
					$leftmenu->setActive('medical_places/pharmacy');
				break;
			case Model_Clinic::OPTICS:
					$leftmenu->setActive('medical_places/optics');
				break;
		
		}
		$this->renderBlocks();
		
	}
	/** Add and Edit clinic **/ 
	public function action_editclinic()
	{ 
		$this->_initClinic(); 	
		$session = App::model('store/session');
		$this->loadBlocks('clinic');
		$contentblock = $this->getBlock('content');
		$breadcrumb = $this->getBlock('breadcrumbs');
		$breadcrumb->addCrumb('action',array('label' => App::registry('place_name'),
												'title' => App::registry('place_name'),
												'link' => 'clinic/index',
												'query' => array('type' => $this->getRequest()->query('type'))));
		$leftmenu = $this->getBlock('leftmenu');
		$clinicmodel = App::model('clinic',false);
		if($this->getRequest()->query('id')) {
			$clinicmodel->loadByAllLanguages($this->getRequest()->query('id'));
			if(!$clinicmodel->getId()) {
				$clinicmodel->setType($this->getRequest()->query('type'));
			}
			$clinicmodel->setVideo(array());
			if($session->getFormData()) { 
				$this->_localSessionData(); 
				$clinicmodel->addData($session->getFormData()); 
				$session->unsetData('form_data');
			} 
			$clinicmodel->unsetData('timeerror');
			if($session->getTimeerror()) {
				$clinicmodel->setTimeError($session->getTimeerror());
				$session->unsetData('timeerror');
			}
			$this->getBlock('head')->setTitle(__('Edit :clinic',array(':clinic' => $clinicmodel->getClinicName(1))));
			$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Edit - <span class="semi-bold">:clinic</span>',array(':clinic' =>$clinicmodel->getClinicName(1))));
			$breadcrumb->addCrumb('editInsurance',array('label' => __('Edit - :clinic',array(':clinic' => $clinicmodel->getClinicName(1))),
												'title' => __('Edit - :clinic',array(':clinic' => $clinicmodel->getClinicName(1)))
							)); 
		} else {
			if($session->getFormData()) { 
					$this->_localSessionData();
					$clinicmodel->addData($session->getFormData()); 
					$session->unsetData('form_data');
				}
			if(!$clinicmodel->getId()) {
				$clinicmodel->setType($this->getRequest()->query('type'));
			}
			$this->getBlock('head')->setTitle(__('Add :place_name',array(':place_name' => App::registry('place_name'))));
			$contentblock->setPageTitle('<i class="fa fa-money" ></i>&nbsp;'.__('Add :place_name',array(':place_name' => App::registry('place_name'))));
			$breadcrumb->addCrumb('editClinic',array('label' => __('Add :place_name',array(':place_name' => App::registry('place_name'))),
												'title' => __('Add :place_name',array(':place_name' => App::registry('place_name')))
							)); 
		}
		switch($this->getRequest()->query('type')) {
			default:
			case Model_Clinic::CLINIC:
					$leftmenu->setActive('medical_places/clinic');
				break;
			case Model_Clinic::HOSPITAL:
					$leftmenu->setActive('medical_places/hospital');
				break;
			case Model_Clinic::LABS:
					$leftmenu->setActive('medical_places/labs');
				break;
			case Model_Clinic::PHARMACY:
					$leftmenu->setActive('medical_places/pharmacy');
				break;
			case Model_Clinic::OPTICS:
					$leftmenu->setActive('medical_places/optics');
				break;
		
		}
		App::register('clinic',$clinicmodel);
		$this->getBlock('clinicedit')->setClinic($clinicmodel);
		$this->getBlock('gallery')->setClinic($clinicmodel);
		$this->getBlock('general')->setClinic($clinicmodel);
		$this->renderBlocks();
	}
	
	public function _localSessionData()
	{
		$session = App::model('store/session');
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
	
	/** Save clinic **/ 
	public function action_saveclinic()
	{
		switch($this->getRequest()->query('type')) {
			
			case Model_Clinic::CLINIC:
					App::register('place_name',__('Clinic'));
				break;
			case Model_Clinic::HOSPITAL:
					App::register('place_name',__('Hospital'));
				break;
			case Model_Clinic::LABS:
					App::register('place_name',__('Labs'));
				break;
			case Model_Clinic::PHARMACY:
					App::register('place_name',__('Pharmacy'));
				break;
			case Model_Clinic::OPTICS:
					App::register('place_name',__('Optics'));
				break;
			default:
				Notice::add(Notice::ERROR,__('Invalid Page'));
				$this->_redirect('clinic/index',array('type' => Model_Clinic::CLINIC));
		}
		$request = $this->getRequest();
		$data = $request->post();	
		$session = App::model('store/session');
		$query = $this->getRequest()->query();
		$backto = isset($data['backto']);
		$success = false;
        $errors = array();
			try { 
					$clinicmodel = App::model('clinic');
					if($request->post('clinic_id')) {
						$clinicmodel->setClinicId($request->post('clinic_id'));
						$clinicmodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					} else { 
						$clinicmodel->setCreatedDate(date("Y-m-d H:i:s",time()));
						$clinicmodel->setUpdatedDate(date("Y-m-d H:i:s",time()));
					} 
					$clinicmodel->setClinicId($request->post('clinic_id'));
					if($request->post('area_id')){
						$clinicmodel->setCountry($request->post('country_id'));
						$clinicmodel->setCity($request->post('city_id'));
						$clinicmodel->setArea($request->post('area_id'));
					}
					$clinicmodel->setClinicStatus($request->post('clinic_status'));
					$clinicmodel->addData($request->post());
					$validate = $clinicmodel->validate(); 
					$clinicmodel->saveClinic(); 
					
					$success = true;
			}catch(Validation_Exception $ve) {
					$session->setDatas('form_data',$request->post());
					Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('emailtemplate',true));
					$errors = $ve->array->errors('emailtemplate',true);
					if($request->post('clinic_id')) {
						$query['clinic_id'] = $request->post('clinic_id');
					}
					$this->_redirect('clinic/editclinic',$query);
					return;
			}catch(Kohana_Exception $ke) {
				//Log::Instance()->add(Log::ERROR, $ke);

			} catch(Exception $e) { 
				Log::Instance()->add(Log::ERROR, $e);
			}
			if($success) {
					if($request->post('clinic_id')) {
						Notice::add(Notice::SUCCESS, __(':place_name has been updated',array(':place_name' => App::registry('place_name'))));
					}else{
						Notice::add(Notice::SUCCESS, __(':place_name has been added',array(':place_name' => App::registry('place_name'))));
					}
			}
			if($clinicmodel->getClinicId()) {
				$query['id'] = $clinicmodel->getClinicId();
			}
			if($backto){ 
				$this->_redirect('clinic/editclinic',$query);
			}else{
				unset($query['id']);
				unset($query['tab']);
				$this->_redirect('clinic/index',$query);
			}	
		
	}
	/** Delete clinic **/ 
	public function action_deleteclinic()
	{
		$query = $this->getRequest()->query();
		$type = $this->getRequest()->query('type');
		unset($query['id']);
		$typename = App::model('clinic')->getTypeTextName($type);
		$clinic_id = $this->getRequest()->query('id');
		$clinic = App::model('clinic')->deleterow($clinic_id,'clinic_id');
		Notice::add(Notice::SUCCESS, __(':place_name has been deleted successfully',array(':place_name' => $typename)));
		$this->_redirect('clinic/index',$query);
	}
	/** Ajax scroll load clinic list**/ 
	public function action_ajaxclinic()
	{
		$this->loadBlocks('clinic');
		$output = $this->getBlock('cliniclist')->toHtml();
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
				$uploaddir = 'uploads/clinic'.DIRECTORY_SEPARATOR.$this->getRequest()->query('id');
				if(!file_exists(DOCROOT.$uploaddir)) {
					mkdir(DOCROOT.$uploaddir,0777,true);
				}
                $filename = $this->_save_image($_FILES['gallery_image'],DOCROOT.$uploaddir);
				$json['file'] = basename($filename);
				$model = App::model('clinic/gallery',false)->setClinicId($this->getRequest()->query('id'))
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
			$clinicid = $request->query('id');
			$delete = DB::delete(App::model('clinic/gallery')->getTableName())->where('file','=',$image)->where('clinic_id','=',$clinicid)
						->execute();
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
			$clinicid = $request->query('id');
			DB::update(App::model('clinic/gallery')->getTableName())->set(array('thumbnail' => 0))->where('clinic_id','=',$clinicid)
						->execute();
			$update = DB::update(App::model('clinic/gallery')->getTableName())->set(array('thumbnail' => true))->where('file','=',$image)->where('clinic_id','=',$clinicid)->execute();
			$json['success'] = true;
		}
		$this->getResponse()->body(json_encode($json));
	}
	
	
	
	public function action_addvideo()
	{
		$this->_initClinic();
		$success = false;
		$session = App::model('store/session');
		$request = $this->getRequest();
		$query = $request->query();
		try {
			$this->getClinic()->ValidateVideos($request->post());
			$this->getClinic()->setVideoTitle($request->post('title'))->setVideoDescription($request->post('description'))->addVideo($request->post('video')); 
			$success = true;
		}  catch(Validation_Exception $ve) {
				$session->setDatas('form_data',array('video' => $request->post()));
				Notice::add(Notice::VALIDATION, 'Validation failed:', NULL, $ve->array->errors('validation',true)); 
		} catch(Exception $e) {
			Notice::add(Notice::ERROR, $e->getMessage());
		}
		if($success) {  
			Notice::add(Notice::SUCCESS, __('Video added'));
		}
		$this->_redirect('clinic/editclinic',$query); 
	}
	
	public function action_deletevideo()
	{
		$this->_initClinic();
		$success = false;
		$session = App::model('store/session');
		$request = $this->getRequest();
		$query = $request->query();
		try {
			if(!isset($query['vid'])) {
				throw new Kohana_Exception(__('Invalid Video'));
			}
			$this->getClinic()->removeVideo($query['vid']); 
			$success = true;
		} catch(Exception $e) {
			Notice::add(Notice::ERROR, $e->getMessage());
		}
		if($success) {  
			Notice::add(Notice::SUCCESS, __('Video Removed'));
		}
		unset($query['vid']);
		$this->_redirect('clinic/editclinic',$query); 
	}
	
	
	public function action_settimings()
	{
		$this->_initClinic();
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
				$model->setEntityTypeId(Model_Clinic::ENTITY_TYPE_ID)->setEntityId($this->getClinic()->getId())->deleteTimings();
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
				/*$this->getUser()->setAppointmentDuration($request->post('appointment_duration'));
				$this->getUser()->save();*/
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
		$this->_redirect('clinic/editclinic',$query); 
	}
	
	public function action_getdoctors()
	{
		$doctors = App::model('user',false)->selectAttributes(array('first_name','primary_email_address'))->filter('user_type',array('=',1));
		if($this->getRequest()->query('q')) {
			$doctors->filter('first_name',array('like','%'.$this->getRequest()->query('q').'%'));
		}
		$doctors->getSelect()->limit(10);
		$collection = $doctors->loadCollection();
		$doctorset = array();
		foreach($collection as $c) {
			$doctorset[] = array('doctor_id' => $c->getId(),'doctor_name' => $c->getFirstName()? $c->getFirstName(): $c->getPrimaryEmailAddress());
		}
		$this->getResponse()->body(json_encode($doctorset)); 
	}
	
	public function action_exportexcel()
	{
		$date = str_replace(" ","_",Date::formatted_time());
		$fileName   = 'Clinic_'.$date.'.xls';
		$this->loadBlocks('clinic'); 
		$output = $this->getBlock('cliniclist')->getCsvFile();
		$this->_prepareDownloadResponse($fileName, $output);
	}
	
	public function action_getcity()
	{
		$this->auto_render = false;
		$this->loadBlocks('clinic');
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
		$this->loadBlocks('clinic');
		$city = $this->getRequest()->query('city_id');
		$area = $this->getRequest()->query('area_id');
		$output = $this->getBlock('area')->setCityId($city)->setAreaId($area)->toHtml();
		$this->getResponse()->body($output); 
	}
	
	public function action_getdepartmentlists()
	{
		$dep_lists = App::model('core/department')->getDepartment($this->getRequest()->query('q'));
		$this->getResponse()->body(json_encode($dep_lists));
	}
	
	public function action_massdeleteclinic()
	{
		$request = $this->getRequest();
		$data = $request->post();
		$query = $this->getRequest()->query();
		$type = $this->getRequest()->query('type');
		$typename = App::model('clinic')->getTypeTextName($type);
		$clinicmodel = App::model('clinic');
		$count_arr = explode(',',$data['clinic_id']);
		$result = $clinicmodel->massDeleteClinic($count_arr,$type);
		
		if($result > 1):
			Notice::add(Notice::SUCCESS, __(':count :name has been deleted successfully',array(':count' => $result,':name' => $typename)));
			$this->_redirect('clinic/index',$query);
		endif;
		Notice::add(Notice::SUCCESS, __(':name has been deleted successfully',array(':name' => $typename)));
		$this->_redirect('clinic/index',$query);
	}
	
}
