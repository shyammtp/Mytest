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
class Model_Api_Location extends Model_RestAPI {
	 
		 
	public function getCountries()
	{ 
		$countries = App::model('core/country')->getAllCountries();
		 
		$countrylist = array();
		foreach($countries as $c) {
			$default = App::getConfig('COUNTRY',Model_Core_Place::ADMIN);
			$countrylist[] = array('country_name' => $c->getCountryName(),
								   'country_id' => $c->getCountryId(),
								   'default' => ($default == $c->getCountryId() ? true : false));
		} 
		return array('country' => $countrylist);	 
	}
	
	public function getCities()
	{
		$select = DB::select(array('lng_table.city_name','city_name'),'main_table.city_id','main_table.url')->from(array(App::model('core/city')->getTableName(),'main_table'))
						->joinLanguage(App::model('core/city'),'main_table','lng_table',App::getCurrentLanguageId())
						->where('country_id','=',Arr::get($this->params,'country_id'))
						->where('city_status','=',1)
						->execute()
						->as_array();		 
		return array('city' => $select);	 
	}
	
	public function getAreas()
	{
		$areas = array();
		$ares = App::model('core/area')->getAreaByCity(Arr::get($this->params,'city_id')); 
		foreach($ares as $a) {
			$selected = Arr::get($this->params,'area_id') == $a->getId() ? true: false;
			$areas[] = array('name' => $a->getAreaName(),'id' => $a->getId(),'url' => $a->getUrl(),'selected' => $selected);
		}
		return array('area' => $areas);	 
	}
}	
