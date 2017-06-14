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
class Model_Api_Search extends Model_RestAPI {
	
    private $_offset;
	private $_select;
	private $_firstPage = 1;
	private $_lastPage;
    private $_totalItem = 0;
	public function getSuggestions()
	{
		$result = App::model('core/search')->suggestions(Arr::get($this->params,'q'));
		return array('suggestions' => $result);
	}
	
	private function getInsurance()
	{
		if(!$this->hasData("insurance")) {
			$model = App::model('insurance',false);
			if(Arr::get($this->params,'insurance')) {
				$model->load(Arr::get($this->params,'insurance'));
			}
			$this->setData("insurance",$model);
		}
		return $this->getData("insurance");
	}
	
	public function getDoctors()
	{
		$term = Arr::get($this->params,'q');  
		$subsql = "(SELECT entity_id FROM tags WHERE tag_name like '%".$term."%' and entity_type_id = 1)"; 
		$this->_select = App::model('user',false)->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->selectAttributes(array('user_id','social_title','profile_image','first_name','experience','qualification','mobile'));
        $this->_select->filter('user_id',array('in',DB::expr($subsql)));        
        if($this->getInsurance()->getId()) {
            $this->_select->getSelect()->join(array(App::model('insurance/entity')->getTableName(),'ie'),'inner')
                        ->on('ie.insurance_id','=',DB::expr($this->getInsurance()->getId()))
                        ->on('ie.entity_type_id','=', DB::expr(Model_User::ENTITY_TYPE_ID))    
                        ->on('ie.entity_id','=', 'main_table.user_id');
        } else {
            $this->_select->getSelect()->join(array(App::model('subscription')->getTableName(),'s'),'inner')
                        ->on('s.entity_type','=',DB::expr(Model_User::ANGES_SAM))
                        ->on('s.entity_id','=','main_table.user_id')
                        ->where('s.subscription_date','>',Date::formatted_time());
        }
        $country = App::instance()->getApi()->getCountry();
        if($country->getId()){
            $this->_select->filter('country',array('=',$country->getId()));
        } 
        $city = App::instance()->getApi()->getCity();
        if($city->getId()){
            $this->_select->filter('city',array('=',$city->getId()));
        } 
        $area = App::instance()->getApi()->getArea();
        if($area->getId()){
            $this->_select->filter('area',array('=',$area->getId()));
        }
		$this->_getTotalItem(); 
        $this->_select->limit($this->_getPerPage())
				->offset($this->_getOffset()); 
		$result =  $this->_select->loadCollection();
		$collection  = array();
		foreach($result as $r) {
			$s = array();
			$s = $r->getData();
			$s['full_name'] = $r->getFullName();
			$s['mobilenumber'] = $r->getMobile();
			$s['is_subscribed'] = $r->hasSubscribed();
			$s['profile_imageurl'] = $r->getProfileImageUrl('w400','h400',true);
			$s['departments'] = array();
			foreach($r->getDepartments() as $dep) {
				$s['departments'][] = $dep->getData();
			}
			$s['insurance'] = array();
			foreach($r->getInsurance() as $ins) {
				$s['insurance'][] = $ins->getData();
			} 
			$s['clinics'] = array();
			foreach($r->getClinics() as $cli) {
				$s['clinics'][] = $cli->getData();
			} 
			$s['timings'] = App::helper('time')->setTimeSets($r->getTimings())->formatGroupTime(true);
			
			$collection[] = $s;
		}
        return array('results' => $collection,'totalitem' => $this->_totalItem,'insurance' => $this->getInsurance()->getData());
	}
	
	public function _getTotalItem()
    { 
        if(!$this->_totalItem) { 
			$pagination_query = clone $this->_select->getSelect();
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
	
	public function getMedicalPlaces()
	{
		$term = Arr::get($this->params,'q'); 
		$subsql = "(SELECT entity_id FROM tags WHERE tag_name like '%".$term."%' and entity_type_id = 4)"; 
        $this->_select = App::model('clinic',false)->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(true)->selectAttributes(array('clinic_id','clinic_name','area','country','city','sub_text','address','about','phone','facilities','services','videos'));        
		
		if($term) {
			$this->_select->filter('clinic_id',array('in',DB::expr($subsql)));
		}
		if($this->getInsurance()->getId()) {
            $this->_select->getSelect()->join(array(App::model('insurance/entity')->getTableName(),'ie'),'inner')
                        ->on('ie.insurance_id','=',DB::expr($this->getInsurance()->getId()))
                        ->on('ie.entity_type_id','=', DB::expr(Model_Clinic::ENTITY_TYPE_ID))    
                        ->on('ie.entity_id','=', 'main_table.clinic_id');
        } else {
            $this->_select->getSelect()->join(array(App::model('subscription')->getTableName(),'s'),'inner');			
			switch(Arr::get($this->params,'for')) {
				default:
				case "clinic":
					$this->_select->getSelect()->on('s.entity_type','=',DB::expr(Model_Clinic::CLINIC)); 
				break;
				case "hospital":
					$this->_select->getSelect()->on('s.entity_type','=',DB::expr(Model_Clinic::HOSPITAL));  
				break;
				case "pharmacy":
					$this->_select->getSelect()->on('s.entity_type','=',DB::expr(Model_Clinic::PHARMACY));  
				break;
				case "optics":
					$this->_select->getSelect()->on('s.entity_type','=',DB::expr(Model_Clinic::OPTICS));  
				break;
				case "labs":
					$this->_select->getSelect()->on('s.entity_type','=',DB::expr(Model_Clinic::LABS));  
				break;
			}
			
                        
             $this->_select->getSelect()->on('s.entity_id','=','main_table.clinic_id')
                        ->where('s.subscription_date','>',Date::formatted_time());
        }
		$type = '';
		switch(Arr::get($this->params,'for')) {
			default:
			case "clinic":
				$type = Model_Clinic::CLINIC;
				$this->_select->filter('type',array('=',Model_Clinic::CLINIC)); 
			break;
			case "hospital":
				$type = Model_Clinic::HOSPITAL;
				$this->_select->filter('type',array('=',Model_Clinic::HOSPITAL)); 
			break;
			case "pharmacy":
				$type = Model_Clinic::PHARMACY;
				$this->_select->filter('type',array('=',Model_Clinic::PHARMACY)); 
			break;
			case "optics":
				$type = Model_Clinic::OPTICS;
				$this->_select->filter('type',array('=',Model_Clinic::OPTICS)); 
			break;
			case "labs":
				$type = Model_Clinic::LABS;
				$this->_select->filter('type',array('=',Model_Clinic::LABS)); 
			break;
		}
		$country = App::instance()->getApi()->getCountry();
        if($country->getId()){
            $this->_select->filter('country',array('=',$country->getId()));
        } 
        $city = App::instance()->getApi()->getCity();
        if($city->getId()){
            $this->_select->filter('city',array('=',$city->getId()));
        } 
        $area = App::instance()->getApi()->getArea();
        if($area->getId()){
            $this->_select->filter('area',array('=',$area->getId()));
        } 
		$this->_getTotalItem(); 
        $this->_select->limit($this->_getPerPage())
				->offset($this->_getOffset());
		 $result =  $this->_select->loadCollection();
		$collection  = array();
		foreach($result as $r) {
			$s = array();
			$s = $r->getData();
		 
			$s['full_name'] = $r->getClinicName();
			$s['facilities'] = $r->getFacilities(false);
			$s['services'] = $r->getServices(false);
			$s['phone'] = $r->getPhoneNumbers();
			$s['area_text'] = $r->getAreaText();
			$s['videos'] = $r->getVideos();
			$s['is_subscribed'] = $r->setType($type)->hasSubscribed();
			$s['thumbnail'] = $r->getThumbnail('w100',true);
			$s['departments'] = array();
			foreach($r->getDepartments() as $dep) {
				$s['departments'][] = $dep->getData();
			}
			$s['insurance'] = array();
			foreach($r->getInsurance() as $ins) {
					$d = $ins->getData();
					$d['logo'] = $ins->getLogo();
					$s['insurance'][] = $d;
			} 
			$s['doctors'] = array();
			foreach($r->getDoctors() as $cli) {
				$s['doctors'][] = $cli->getData();
			} 
			$s['timings'] = App::helper('time')->setTimeSets($r->getTimings())->formatGroupTime(true);
			
			$collection[] = $s;
		}
        return array('results' => $collection,'totalitem' => $this->_totalItem,'insurance' => $this->getInsurance()->getData());
	}
}	
