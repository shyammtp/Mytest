<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * Session Model base class.
 *
 * @package    Kohana/Database
 * @category   Models
 * @author     Kohana Team
 * @copyright  (c) 2008-2012 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Model_Store_Clinic_Event extends Model_Abstract { 

	public function othersave(Kohana_Core_Object $obj)
	{
		$clinic = $obj->getClinic();
		$post = $obj->getPost();
		if(isset($post['deparment_id'])) { 
			$department = Arr::get($post,'deparment_id');
			$department = explode(",",$department);
			$departmentmodel = App::model('core/department_entity',false);
			$departmentmodel->setEntityTypeId(Model_Clinic::ENTITY_TYPE_ID)
							->setEntityId($clinic->getId());
			$departmentmodel->deleteBefore();
			try {
				foreach($department as $depid) {
					$departmentmodel->setDepartmentId($depid);
					$departmentmodel->save(); 
					$departmentmodel->unsetData('department_id');
				} 
			} catch(Exception $e) {
				
			}
		}
		
		if(isset($post['doctor_id'])) {
			$doctorids = Arr::get($post,'doctor_id');
			$doctor = array_filter(explode(",",$doctorids));
			$doctormodel = App::model('user/doctor_clinic',false);
			$doctormodel->setClinicId($clinic->getId());
			$doctormodel->deleteBefore();
			try {
				foreach($doctor as $depid) {
					$doctormodel->setDoctorId($depid);
					$doctormodel->save(); 
					$doctormodel->unsetData('doctor_id');
				} 
			} catch(Exception $e) {
				
			}
		}
		 
		if(isset($post['insurance'])) {
			$insurancemodel = App::model('insurance/entity',false);
			$insurancemodel->setEntityTypeId(Model_Clinic::ENTITY_TYPE_ID)
							->setEntityId($clinic->getId()); 
			$insurancemodel->deleteBefore();
			try {
				foreach($post['insurance'] as $depid) {
					$insurancemodel->setInsuranceId($depid);
					$insurancemodel->save(); 
					$insurancemodel->unsetData('insurance_id');
				} 
			} catch(Exception $e) {
				
			}
		}
		$type = Model_Core_Search::CLINIC;
		if($clinic->isLabs()){
			$type = Model_Core_Search::LABS;
		}
		if($clinic->isPharmacy()){
			$type = Model_Core_Search::PHARMACY;
		}
		if($clinic->isHospital()){
			$type = Model_Core_Search::HOSPITAL;
		}
		if($clinic->isOptics()){
			$type = Model_Core_Search::OPTICS;
		} 
		$cname = Arr::get($post,'clinic_name');
		if(!empty($cname)) {
			$language = App::model('core/language')->getLanguages();
			foreach($language as $lang) {
				$clinicname = Arr::get($cname,Arr::get($lang,'language_id'));
				if($clinicname) {
					$search = App::model('core/search',false)->setLanguage(Arr::get($lang,'language_id'))->setTerm($clinicname)->setStatus($clinic->getClinicStatus())->addTerm($clinic->getId(),$type);
				}
			}
		} 
		
	}
	 
	public function otherdelete(Kohana_Core_Object $obj)
	{
		$clinic = $obj->getClinic();
		if($clinic->getId()) {
			$departmentmodel = App::model('core/department_entity',false);
			$departmentmodel->setEntityTypeId(Model_Clinic::ENTITY_TYPE_ID)
							->setEntityId($clinic->getId());
			$departmentmodel->deleteBefore();
			
			$doctormodel = App::model('user/doctor_clinic',false);
			$doctormodel->setClinicId($clinic->getId());
			$doctormodel->deleteBefore();
			
			$insurancemodel = App::model('insurance/entity',false);
			$insurancemodel->setEntityTypeId(Model_Clinic::ENTITY_TYPE_ID)
							->setEntityId($clinic->getId()); 
			$insurancemodel->deleteBefore();
		}
	}
	
	public function tagsave(Kohana_Core_Object $obj)
	{
		$clinic = $obj->getClinic();
		$post = $obj->getPost();
		$tags = array();
		$tags[] = $clinic->getClinicName(1);
		if($clinic->getClinicName(2)) {
			$tags[] = $clinic->getClinicName(2);
		}
		$departments = $clinic->getDepartments();
		$deps = array();
		foreach($departments as $d)
		{
			$depar = App::model('core/department',false)->loadAllLanguages($d->getDepartmentId());
			$dpna = array();
			$deprtmentname = $depar->getDepartmentName();
			if(!empty($deprtmentname)) {
				foreach($depar->getDepartmentName() as $langid => $name) {
					if(trim($name)) {
						$dpna[] = $name;
					}
				} 
				$deps[] = implode(", ",$dpna);
			}
		}
		if(count($deps)) {
			$tags[] = implode(", ",$deps);
		}
		$insurance = $clinic->getInsurance();
		$ins = array();
		foreach($insurance as $d)
		{
			$ins[] = $d->getInsuranceName();
		}
		if(count($ins)) {
			$tags[] = implode(", ",$ins);
		}
		if(!is_array($clinic->getFacilities()) && $clinic->getFacilities()) {
			
			$tags[] = (string)$clinic->getFacilities();
		}
		if(!is_array($clinic->getServices()) && $clinic->getServices()) {
			$tags[] = (string)$clinic->getServices();
		}
		if(!is_array($clinic->getTags()) && $clinic->getTags()) {
			$tags[] = (string)$clinic->getTags();
		}
		
		$tagmodel = App::model('core/tags',false);
		if($tagid = $tagmodel->checkTagExists($clinic->getId(),Model_Clinic::ENTITY_TYPE_ID)) {
			$tagmodel->load($tagid);
		} 
		$tagmodel->setEntityId($clinic->getId())->setEntityTypeId(Model_Clinic::ENTITY_TYPE_ID)
				->setTagName(implode("|",$tags))->save();
				
		$this->insertUrl($obj);
	}
	
	public function insertUrl(Kohana_Core_Object $obj)
	{
		$clinic = $obj->getClinic(); 
		$urlmodel = App::model('url',false);
		if($clinic->getUrlKey())
		{ 
			$targetpath = 'view_clinic/detail';
			try{
				if($clinic->getOldUrlKey() != $clinic->getUrlKey()) {
					App::model('url',false)->deleterow($clinic->getTypeUrl().'/'.$clinic->getOldUrlKey(),'request_path');
				}				 
				$urlmodel->saveUrlRewrite($clinic->getUrlPath(),$targetpath,array('_id' =>  $clinic->getId()));				
			} catch(Exception $e) { 
				Log::Instance()->add(Log::ERROR, $e);
			}
		}
	}
	
	public function updateurl(Kohana_Core_Object $obj)
	{
		$clinic = App::model('clinic',false)->load($obj->getClinic()->getId());		
		if($clinic->getId()) {
			$obj->getClinic()->setOldUrlKey($clinic->getUrlKey()); 
		}
	}
	
}
