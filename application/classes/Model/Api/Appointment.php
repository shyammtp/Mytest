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
class Model_Api_Appointment extends Model_RestAPI {
	
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
	
	public function getTimings()
	{
		$date = Arr::get($this->params,'date');
		if(!$date) {
			$date = Date::formatted_time('now','Y-m-d');
		}
		if(!$this->_getDoctor()->isDoctor()) {
			throw new Kohana_Exception(__('Invalid Page'),NULL,20);
		}
		$timeslots = $this->_getDoctor()->getDayTimeSlots($date,$this->_getUser()->getId());
		return array('timings' => Arr::get($timeslots,'slots',array())); 
	}
	
	public function bookappointment()
	{
		$response = array(); 
		if(!Arr::get($this->params,'name')) {
			throw new Kohana_Exception(__('Invalid Paramter Data: Name Must not empty'),NULL,30); 
		}
		if(!Arr::get($this->params,'description')) {
			throw new Kohana_Exception(__('Invalid Paramter Data: Description Must not empty'),NULL,30); 
		} 
		if(!Arr::get($this->params,'datetime')) {
			throw new Kohana_Exception(__('Invalid Paramter Data: Datetime Must not empty'),NULL,30); 
		}
		if(!strtotime(Arr::get($this->params,'datetime'))) {
			throw new Kohana_Exception(__('Invalid Paramter Data: Datetime is not valid'),NULL,30); 
		}
		if(strtotime(Arr::get($this->params,'datetime')) <= time()) {
			throw new Kohana_Exception(__('Invalid Paramter Data: Datetime is not valid'),NULL,30); 
		}
		if(!$this->_getDoctor()->isDoctor()) {
			throw new Kohana_Exception(__('Invalid Doctor'),NULL,32); 
		}
		try {
			$model = App::model('core/appointments',false)->addData($this->params)->setDoctor($this->_getDoctor());
			$model->saveAppointment();
			$response['success'] = true; 
		} catch(Kohana_Exception $e) { 
			throw $e;
		}
		return $response;
	}
}	
