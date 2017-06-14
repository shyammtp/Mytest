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
class Model_Api_View extends Model_RestAPI {
	 
	private $_entity;
	
	
	private function getUser()
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
	
	public function getDoctors()
	{
		$entity_id = Arr::get($this->params,'entity_id'); 
		$r =  App::model('user',false)->setLanguage(App::getCurrentLanguageId())->load($entity_id);
		$this->_entity = $r;
		if(!$r->getId()) {
			throw new Kohana_Exception(__('Invalid Page'),NULL,20);
		}
		if(!$r->isDoctor()) {
			throw new Kohana_Exception(__('Invalid Page'),NULL,20);
		} 
		if(!$r->hasSubscribed()) {
			throw new Kohana_Exception(__('Invalid Page'),NULL,20);
		}
		$s = array(); 
		$s['full_name'] = $r->getFullName();
		$s['venue'] = $r->getVenue();
		$s['user_id'] = $r->getUserId();
		$s['gender'] = $r->getGender();
		$s['phone'] = $r->getPhoneNumbers();  
		$s['about'] = $r->getAbout();
		$s['latitude'] = $r->getLatitude();
		$s['longitude'] = $r->getLongitude();
		$s['experience'] = $r->getExperience();
		$s['qualification'] = $r->getQualification();
		$s['videos'] = array_values($r->getVideos());
		$s['is_subscribed'] = $r->hasSubscribed();
		$s['is_booked_already'] = $this->isBookedAlready();
		$s['gallery'] = array_values($r->getGallerysImages());
		$s['profile_imageurl'] = $r->getProfileImageUrl('w400','h400',true);
		$s['departments'] = array();
		foreach($r->getDepartments() as $dep) {
			$s['departments'][] = $dep->getData();
		}
		$s['insurance'] = array();
		foreach($r->getInsurance() as $ins) {
			$da = $ins->getData();
			$da['logo'] = $ins->getLogo();
			$s['insurance'][] =$da;
		} 
		$s['clinics'] = array();
		foreach($r->getClinics() as $cli) {
			$s['clinics'][] = $cli->getData();
		} 
		$s['timings'] = App::helper('time')->setTimeSets($r->getTimings())->formatGroupTime(true);
		$s['weburl'] = $r->getUrl();
        return array('results' => $s);
	}
	 
	
	public function getMedicalPlaces()
	{
		$entity_id = Arr::get($this->params,'entity_id'); 
		$r =  App::model('clinic',false)->loadSelectSet();
		switch(Arr::get($this->params,'for')) {
			default:
			case "clinic": 
				$r->getSelectSet()->where('type','=',Model_Clinic::CLINIC);  
			break;
			case "hospital":
				$r->getSelectSet()->where('type','=',Model_Clinic::HOSPITAL); 
			break;
			case "pharmacy":
				$r->getSelectSet()->where('type','=',Model_Clinic::PHARMACY); 
			break;
			case "optics":
				$r->getSelectSet()->where('type','=',Model_Clinic::OPTICS); 
			break;
			case "labs":
				$r->getSelectSet()->where('type','=',Model_Clinic::LABS); 
			break;
		}
		$r->setLanguage(App::getCurrentLanguageId())->load($entity_id); 
		if(!$r->getId()) {
			throw new Kohana_Exception(__('Invalid Page'),NULL,20);
		} 
		if(!$r->hasSubscribed()) {
			throw new Kohana_Exception(__('Invalid Page'),NULL,20);
		}
		 
		$s = array();
		$s = $r->getData();
		$s['full_name'] = $r->getClinicName();
		$s['facilities'] = $r->getFacilities(false);
		$s['services'] = $r->getServices(false);
		$s['phone'] = $r->getPhoneNumbers();
		$s['area_text'] = $r->getAreaText();
		$s['videos'] = $r->getVideos();
		$s['is_subscribed'] = $r->hasSubscribed();
		$s['thumbnail'] = $r->getThumbnail('w100',true);
		$s['departments'] = array();
		foreach($r->getDepartments() as $dep) {
			$s['departments'][] = $dep->getData();
		}
		$s['insurance'] = array();
		foreach($r->getInsurance() as $ins) {
			$s['insurance'][] = $ins->getData();
		} 
		$s['doctors'] = array();
		foreach($r->getDoctors() as $cli) {
			$doctor = App::model('user',false)->load($cli->getId());
			$dc = array();
			$dc['full_name'] = $doctor->getFullName();
			$dc['user_id'] = $doctor->getUserId();
			$dc['gender'] = $doctor->getGender();
			$dc['phone'] = $doctor->getPhoneNumbers();  
			$dc['about'] = $doctor->getAbout();
			$dc['experience'] = $doctor->getExperience();
			$dc['qualification'] = $doctor->getQualification(); 
			$dc['is_subscribed'] = $doctor->hasSubscribed(); 
			$dc['profile_imageurl'] = $doctor->getProfileImageUrl('w100','h100',true);
			$dc['departments'] = array();
			foreach($doctor->getDepartments() as $dep) {
				$dc['departments'][] = $dep->getData();
			}
			$dc['insurance'] = array();
			foreach($doctor->getInsurance() as $ins) {
				$da = $ins->getData();
				$da['logo'] = $ins->getLogo();
				$s['insurance'][] =$da;
			}  
			$dc['timings'] = App::helper('time')->setTimeSets($doctor->getTimings())->formatGroupTime(true);
			$s['doctors'][] = $dc;
		} 
		$s['timings'] = App::helper('time')->setTimeSets($r->getTimings())->formatGroupTime(true);
		$s['weburl'] = $r->getUrl();
        return array('results' => $s);
	}
	
	
	public function getBookedAppointments()
    {
        if(!$this->hasData('booked_appointments')) {
            $model = App::model('core/appointments',false);
            $appt = $model->checkAlreadyPatientBooked($this->getUser()->getId(),$this->_entity->getId());        
            if($appt) {
                $model->load(Arr::get($appt,'appointment_id'));
            }
            $this->setData('booked_appointments',$model);
        }
        return $this->getData('booked_appointments');
    }
    
    public function isBookedAlready()
    {
        $appt = $this->getBookedAppointments();        
        if($appt->getId()) {
            return true;
        }
        return false;
    }
}	
