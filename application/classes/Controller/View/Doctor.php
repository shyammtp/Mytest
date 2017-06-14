<?php defined('SYSPATH') or die('No direct script access.'); 

class Controller_View_Doctor extends Controller_Core_Front {
	
	private $_doctor; 
	
	private function _initData()
	{
		$id = $this->getRequest()->param('_id',$this->getRequest()->query('id'));
		$this->_doctor = App::model('user',false)->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->selectAttributes('*')
					->filter('user_type',array('=',Model_User::DOCTOR))
					->filter('status',array('=',1));  
		if($id) {
			$this->_doctor->filter('user_id',array('=',$id)); 
		}
		$this->_doctor->getCurrent();
		App::register('doctor',$this->_doctor);
	}
	
	public function action_detail()
	{
		$this->_initData();
		if(!$this->_doctor->hasSubscribed()) {
			$this->page404();
		}
		$this->loadBlocks('view');
		$breadcrumb = $this->getBlock('breadcrumbs'); 
		$head = $this->getBlock('head')->setTitle($this->_doctor->getFullName()); 
		$breadcrumb->addCrumb('name',array('label' => $this->_getDoctor()->getFullName(),'title' => $this->_getDoctor()->getFullName())); 
		$this->renderBlocks(); 
	}
	
	private function _getDoctor()
	{
		return $this->_doctor;
	}
	
	public function action_timings()
	{
		$this->_initData();
		$date = $this->getRequest()->query('date');
		if(!$date) {
			$date = Date::formatted_time('now','Y-m-d');
		}
		$timeslots = $this->_getDoctor()->getDayTimeSlots($this->getRequest()->query('date'),$this->getRequest()->query('patient'));
		$this->getResponse()->body(json_encode($timeslots));
	}
	
	public function action_book()
	{
		$this->_initData();
		$request = $this->getRequest();
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
				$model = App::model('core/appointments',false)->addData($request->post())->setDoctor($this->_getDoctor());
				$model->saveAppointment();
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
}
