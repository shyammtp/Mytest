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
class Model_Store_Event extends Model_Abstract {

	public function departmentsaveafter(Kohana_Core_Object $obj)
	{		
		$deptmodel = $obj->getDepartment();
		$post = $obj->getPost();
		$deptname = Arr::get($post,'department_name'); 
		$desc = Arr::get($post,'description');
		$language = App::model('core/language')->getLanguages();
		$infomodel = App::model('core/department_info',false);
		$infomodel->deleterow($deptmodel->getId(),'department_id');
		foreach($language as $langid => $la) {
			if((isset($deptname[$langid]) && $deptname[$langid] != '') ||
			   (isset($desc[$langid]) && $desc[$langid] != '')
			   ){
				$infomodel->setDepartmentId($deptmodel->getId())
							->setLanguageId($langid);
				if(isset($deptname[$langid])){
					$infomodel->setDepartmentName($deptname[$langid]);
				}
				if(isset($desc[$langid])){
					$infomodel->setDescription($desc[$langid]);
				}
				$infomodel->save();
				$infomodel->unsetData();
			}
		}
		
		// Users
		try {
			$select = DB::select('de.entity_id','de.entity_type_id')->from(array(App::model('core/department_entity')->getTableName(),'de')) 
								->where('de.department_id','=',$deptmodel->getId())  
								->execute()->as_array(); 
			foreach($select as $s) {
				 
				if(Arr::get($s,'entity_type_id') == Model_User::ENTITY_TYPE_ID) {
					$userid = Arr::get($s,'entity_id');
					$user = App::model('user',false)->loadByAllLanguages($userid);
					$tags = array();
					$nams = array(); 
					foreach($user->getFirstName() as $names) {
						$nams[] = $names;
					}
					$tags[] = implode(", ",$nams);
					$tags[] = $user->getPrimaryEmailAddress();
					$departments = $user->getDepartments();
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
					$insurance = $user->getInsurance();
					$ins = array();
					foreach($insurance as $d)
					{
						$ins[] = $d->getInsuranceName();
					}
					if(count($ins)) {
						$tags[] = implode(", ",$ins);
					} 
					$tagmodel = App::model('core/tags',false);
					try {
						if($tagid = $tagmodel->checkTagExists($user->getId(),Model_User::ENTITY_TYPE_ID)) {
							$tagmodel->load($tagid);
						}
						$tagmodel->setEntityId($user->getId())->setEntityTypeId(Model_User::ENTITY_TYPE_ID)
								->setTagName(implode("|",$tags));  
						$tagmodel->save();
					} catch(Kohana_Exception $ke) {
						Log::Instance()->add(Log::ERROR, $ke);
					} catch(Exception $e) {
						Log::Instance()->add(Log::ERROR, $e);
					}
				} 
				if(Arr::get($s,'entity_type_id') == Model_Clinic::ENTITY_TYPE_ID) {
					 
					$clinicid = Arr::get($s,'entity_id');
					$clinic = App::model('clinic',false)->loadByAllLanguages($clinicid);
					$tags = array();
					$nams = array(); 
					foreach($clinic->getClinicName() as $names) {
						$nams[] = $names;
					}
					$tags[] = implode(", ",$nams); 
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
					
					try {
						$tagmodel = App::model('core/tags',false);
						if($tagid = $tagmodel->checkTagExists($clinic->getId(),Model_Clinic::ENTITY_TYPE_ID)) {
							$tagmodel->load($tagid);
						}
						$tagmodel->setEntityId($clinic->getId())->setEntityTypeId(Model_Clinic::ENTITY_TYPE_ID)
								->setTagName(implode("|",$tags))->save();
					} catch(Kohana_Exception $ke) { 
						Log::Instance()->add(Log::ERROR, $ke);
					} catch(Exception $e) { 
						Log::Instance()->add(Log::ERROR, $e);
					} 	
				}
			} 
		} catch(Exception $e) { 
			Log::Instance()->add(Log::ERROR, $e);
		} 
	}
	
}	
