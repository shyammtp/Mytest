<?php defined('SYSPATH') OR die('No direct script access.'); 

class Blocks_Front_Contactus extends Blocks_Front_Abstract
{ 
	public function getCity()
	{
		$select = DB::select('main_table.city_id','lng_table.city_name','main_table.url')->from(array(App::model('core/city')->getTableName(),'main_table'))
						->joinLanguage(App::model('core/city'),'main_table','lng_table',App::getCurrentLanguageId())
						->where('country_id','=',App::instance()->getCountry()->getId())
						->where('city_status','=',1)
						->execute()
						->as_array();
		return $select;
	}


}
