<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Search_Results_Labs extends Blocks_Front_Search_Results
{    
    private $_select;
    private $_offset;
	
	public function getInsurance()
    {
        return App::registry('insurance');
    }
	
    public function getResults()
    {
		 
        /*if(!$this->getTerm()) {
            return false;
        }*/
        $subsql = "(SELECT entity_id FROM tags WHERE tag_name like '%".$this->getTerm()."%' and entity_type_id = 4)";
        $this->_select = App::model('clinic',false)->setLanguage(App::getCurrentLanguageId())->setConditionalLanguage(false)->selectAttributes('*');
        $this->_select->filter('type',array('=',Model_Clinic::LABS))->filter('clinic_status',array('=',1)); 
		if($this->getTerm()) { 
				$this->_select->filter('clinic_id',array('in',DB::expr($subsql))); 
		}
		if($this->getInsurance()->getId()) {
            $this->_select->getSelect()->join(array(App::model('insurance/entity')->getTableName(),'ie'),'inner')
                        ->on('ie.insurance_id','=',DB::expr($this->getInsurance()->getId()))
                        ->on('ie.entity_type_id','=', DB::expr(Model_Clinic::ENTITY_TYPE_ID))    
                        ->on('ie.entity_id','=', 'main_table.clinic_id');
        } else {
			 $this->_select->getSelect()->join(array(App::model('subscription')->getTableName(),'s'),'inner')
							->on('s.entity_type','=',DB::expr(Model_Clinic::LABS))
							->on('s.entity_id','=','main_table.clinic_id')
							->where('s.subscription_date','>',Date::formatted_time());
		}
		$country = App::instance()->getCountry();
        if($country->getId()){
            $this->_select->filter('country',array('=',$country->getId()));
        } 
        $city = $this->getCity();
        if($city->getId()){
            $this->_select->filter('city',array('=',$city->getId()));
        } 
        $area = $this->getArea();
        if($area->getId()){
            $this->_select->filter('area',array('=',$area->getId()));
        }
		//print_r($this->_select->getSelect()->__toString());exit;
        $this->setCollection($this->_select);
        $this->_select->limit($this->_getPerPage())
				->offset($this->_getOffset());
        return $this->_select->loadCollection();
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
        $currentpage = $this->getCurrentPage();  
        return $currentpage;
    }
    
    
    private function _getPerPage()
	{
		return $this->getPerPage();
	}
}
