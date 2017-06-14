<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Admin_Area_Edit extends Blocks_Admin_Abstract
{
	protected $_area;
	
	public function getLanguage()
	{
		return App::model('core/language')->getLanguages();
	}
	
	protected function _getArea()
    { 
		if(!$this->_area){
			$this->_area = App::model('admin/area/settings',false)->loadAllLanguages($this->getRequest()->query('id'));
		}
		return $this->_area;
    }
    
	protected function _getCountryInfo()
    { 
		$c = App::model('core/country',false)->setLanguage(App::getCurrentLanguageId())->getResource()->joinLanguageTable();
		$country = $c->getAttributeValues();
		foreach($country as $sel) {
            $options[$sel->getCountryId()] = $sel->getCountryName();
        }
		return $options;
    }
    
	protected function _getCityInfo()
    { 
		$c = App::model('core/city',false)->setLanguage(App::getCurrentLanguageId())->getResource()->joinLanguageTable();
		$city = $c->getAttributeValues();
		foreach($city as $sel) {
            $options[$sel->getCityId()] = $sel->getCityName();
        }
		return $options;
    }
    
	public function _getCitylists()
    { 
		$options=array();
		$city = DB::select('main_table.city_id','lng_table.city_name')->from(array(App::model('admin/city/settings')->getTableName(),'main_table'))
								->joinLanguage(App::model('core/city'),'main_table','lng_table',App::getCurrentLanguageId())
								->where('city_status','=','1')
								->where('country_id','=',$this->getCountryId())
								->as_object()
								->execute();					
		foreach($city as $sel) {
            $options[$sel->city_id] = $sel->city_name;
        }
		return $options;
    }
    
	public function _getArealists()
    { 
		$options=array();
		$area = DB::select('main_table.area_id','lng_table.area_name')->from(array(App::model('admin/area/settings')->getTableName(),'main_table'))
								->joinLanguage(App::model('core/area'),'main_table','lng_table',App::getCurrentLanguageId())
								->where('area_status','=','1')
								->where('city_id','=',$this->getCityId())
								->as_object()
								->execute();					
		foreach($area as $sel) {
            $options[$sel->area_id] = $sel->area_name;
        }
		return $options;
    }
    
}
