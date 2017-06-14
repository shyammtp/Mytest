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
class Model_Api_Clinics extends Model_RestAPI {
	 
	public function getDepartments()
	{
		$dep_lists = App::model('core/department')->getDepartment(Arr::get($this->params,'q'));
		return array('departments' => $dep_lists);
	}
	
	public function getClinics()
	{
		$clinics = App::model('clinic',false)->selectAttributes(array('clinic_name','type'))->filter('clinic_status',array('=',1));
		if(Arr::get($this->params,'q')) {
			$clinics->filter('clinic_name',array('like','%'.Arr::get($this->params,'q').'%'));
		}
		//$clinics->getSelect()->limit(10);
		$collection = $clinics->loadCollection();
		$clinicset = array();
		foreach($collection as $c) { 
			$clinicset[] = array('clinic_id' => $c->getId(),'clinic_name' => $c->getClinicName()." (".$c->getTypeText().")",'clinic_text' => $c->getTypeText());
		}
		return array('clinics' => $clinicset);
	}
	
	public function getInsurances()
	{
		$insurances = App::model('insurance',false)->selectAttributes(array('insurance_name','type'))->filter('insurance_status',array('=',1));
		if(Arr::get($this->params,'q')) {
			$insurances->filter('insurance_name',array('like','%'.Arr::get($this->params,'q').'%'));
		}
		//$insurances->getSelect()->limit(10);
		$collection = $insurances->loadCollection();
		$insuranceset = array();
		foreach($collection as $c) { 
			$insuranceset[] = array('insurance_id' => $c->getId(),'insurance_name' => $c->getInsuranceName(),'insurance_text' => $c->getTypeText());
		}
		return array('insurances' => $insuranceset);
	}
}	
