<?php defined('SYSPATH') OR die('No direct script access.');

class Blocks_Front_Countrycityarea extends Blocks_Front_Abstract
{
	protected $_area;
	
	protected function _getArea()
    { 
		if(!$this->_area){
			$this->_area = App::model('core/area')->load($this->getRequest()->query('id'));
		}
		return $this->_area;
    }
    
	protected function _getCountryInfo()
    { 
		$country = DB::select('main_table.country_id','lng_table.country_name')->from(array(App::model('core/country')->getTableName(),'main_table'))
					
					->joinLanguage(App::model('core/country'),'main_table','lng_table',App::getCurrentLanguageId())
					->where('country_status','=','1')->as_object()->execute();
		foreach($country as $sel) {
            $options[$sel->country_id] = $sel->country_name;
        }
		return $options;
    }
    
	protected function _getCityInfo()
    { 
		$city = DB::select('main_table.city_id','lng_table.city_name')->from(array(App::model('core/city')
								->getTableName(),'main_table'))
								->joinLanguage(App::model('core/city'),'main_table','lng_table',App::getCurrentLanguageId())
								->where('city_status','=','1')
								->as_object()
								->execute();
		foreach($city as $sel) {
            $options[$sel->city_id] = $sel->city_name;
        }
		return $options;
    }
    
	public function _getCitylists()
    { 
		$options=array();
		$city = DB::select('main_table.city_id','lng_table.city_name')->from(array(App::model('core/city')->getTableName(),'main_table'))
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
		$area = DB::select('main_table.area_id','lng_table.area_name')->from(array(App::model('core/area')->getTableName(),'main_table'))
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
